<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use App\Services\OpenpayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    private $openpayService;

    public function __construct(OpenpayService $openpayService)
    {
        $this->openpayService = $openpayService;
    }

    public function processCardPayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id',
            'token' => 'required|string',
            'device_session_id' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            DB::beginTransaction();

            $booking = Booking::findOrFail($request->order_id);

            if ($booking->payment_status !== 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'La orden ya ha sido pagada o cancelada',
                ], 400);
            }

            $payment = Payment::create([
                'order_id' => $booking->id,
                'user_id' => auth()->id(),
                'amount' => $booking->total,
                'currency' => 'MXN',
                'payment_method' => 'card',
                'status' => Payment::STATUS_PENDING,
                'description' => "Pago reserva #{$booking->booking_number}",
            ]);

            $result = $this->openpayService->createCharge(
                token: $request->token,
                amount: $booking->total,
                description: "Pago reserva #{$booking->booking_number}",
                metadata: [
                    'booking_id' => $booking->id,
                    'booking_number' => $booking->booking_number,
                    'payment_id' => $payment->id,
                    'device_session_id' => $request->device_session_id,
                ],
                customer: [
                    'name' => $request->input('customer.name', $booking->customer_name ?? ''),
                    'last_name' => $request->input('customer.last_name', ''),
                    'email' => $request->input('customer.email', $booking->customer_email ?? ''),
                    'phone' => $request->input('customer.phone', $booking->customer_phone ?? ''),
                ]
            );

            if ($result['success']) {
                $payment->update([
                    'openpay_id' => $result['id'],
                    'status' => Payment::STATUS_COMPLETED,
                    'metadata' => array_merge($payment->metadata ?? [], [
                        'authorization' => $result['authorization'],
                        'openpay_response' => $result,
                    ]),
                ]);

                $booking->update([
                    'payment_status' => 'paid',
                    'payment_id' => $payment->openpay_id,
                ]);

                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'Pago procesado exitosamente',
                    'payment_id' => $payment->id,
                    'authorization' => $result['authorization'],
                ]);
            } else {
                $payment->update([
                    'status' => Payment::STATUS_FAILED,
                    'error_message' => $result['error'],
                ]);

                DB::commit();

                return response()->json([
                    'success' => false,
                    'message' => $result['error'],
                    'error_code' => $result['error_code'] ?? null,
                ], 400);
            }

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Error al procesar el pago',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getConfig()
    {
        return response()->json([
            'success' => true,
            'data' => [
                'merchant_id' => config('openpay.merchant_id'),
                'public_key' => config('openpay.public_key'),
                'mode' => config('openpay.mode', 'sandbox'),
                'location' => config('openpay.location', 'MX'),
            ],
        ]);
    }

    public function show(Payment $payment)
    {
        if ($payment->user_id && $payment->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'No autorizado',
            ], 403);
        }

        return response()->json([
            'success' => true,
            'data' => $payment->load('order'),
        ]);
    }

    /**
     * Webhook para recibir notificaciones asíncronas de OpenPay
     * OpenPay envía eventos como: charge.succeeded, charge.failed, charge.cancelled, charge.refunded
     */
    public function handleWebhook(Request $request)
    {
        $payload = $request->all();

        // Log del webhook para debugging
        Log::info('OpenPay Webhook received', $payload);

        // Verificar tipo de evento
        $eventType = $payload['type'] ?? null;
        $transaction = $payload['transaction'] ?? null;

        if (!$eventType || !$transaction) {
            return response()->json(['error' => 'Invalid payload'], 400);
        }

        $openpayId = $transaction['id'] ?? null;
        $status = $transaction['status'] ?? null;

        if (!$openpayId) {
            return response()->json(['error' => 'Missing transaction ID'], 400);
        }

        // Buscar el pago por openpay_id
        $payment = Payment::where('openpay_id', $openpayId)->first();

        if (!$payment) {
            Log::warning("OpenPay Webhook: Payment not found for ID {$openpayId}");
            return response()->json(['error' => 'Payment not found'], 404);
        }

        // Actualizar estado según el evento
        switch ($eventType) {
            case 'charge.succeeded':
                $payment->update([
                    'status' => Payment::STATUS_COMPLETED,
                    'metadata' => array_merge($payment->metadata ?? [], [
                        'webhook_received_at' => now()->toIso8601String(),
                        'openpay_status' => $status,
                        'authorization' => $transaction['authorization'] ?? null,
                    ]),
                ]);

                // Actualizar también el booking
                if ($payment->booking) {
                    $payment->booking->update([
                        'payment_status' => 'paid',
                    ]);
                }

                Log::info("OpenPay Webhook: Payment {$payment->id} marked as completed");
                break;

            case 'charge.failed':
                $payment->update([
                    'status' => Payment::STATUS_FAILED,
                    'error_message' => $transaction['error_message'] ?? 'Pago fallido',
                    'metadata' => array_merge($payment->metadata ?? [], [
                        'webhook_received_at' => now()->toIso8601String(),
                        'openpay_status' => $status,
                        'error_code' => $transaction['error_code'] ?? null,
                    ]),
                ]);

                Log::info("OpenPay Webhook: Payment {$payment->id} marked as failed");
                break;

            case 'charge.cancelled':
                $payment->update([
                    'status' => Payment::STATUS_FAILED,
                    'error_message' => 'Pago cancelado',
                    'metadata' => array_merge($payment->metadata ?? [], [
                        'webhook_received_at' => now()->toIso8601String(),
                        'openpay_status' => $status,
                    ]),
                ]);

                Log::info("OpenPay Webhook: Payment {$payment->id} marked as cancelled");
                break;

            case 'charge.refunded':
                $refundData = $transaction['refund'] ?? null;
                $payment->update([
                    'status' => Payment::STATUS_REFUNDED,
                    'metadata' => array_merge($payment->metadata ?? [], [
                        'webhook_received_at' => now()->toIso8601String(),
                        'openpay_status' => $status,
                        'refund_id' => $refundData['id'] ?? null,
                        'refund_amount' => $refundData['amount'] ?? null,
                    ]),
                ]);

                // Actualizar booking
                if ($payment->booking) {
                    $payment->booking->update([
                        'payment_status' => 'refunded',
                    ]);
                }

                Log::info("OpenPay Webhook: Payment {$payment->id} marked as refunded");
                break;

            default:
                Log::info("OpenPay Webhook: Unhandled event type {$eventType}");
                break;
        }

        return response()->json(['status' => 'ok']);
    }
}
