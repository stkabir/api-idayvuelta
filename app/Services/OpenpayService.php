<?php

namespace App\Services;

use Openpay;
use OpenpayApiError;
use OpenpayApiAuthError;
use OpenpayApiRequestError;
use Illuminate\Support\Facades\Log;

class OpenpayService
{
    private $openpay;

    public function __construct()
    {
        $mode = config('openpay.mode', 'sandbox');
        $merchantId = config('openpay.merchant_id');
        $privateKey = config('openpay.private_key');
        $location = config('openpay.location', 'MX');

        $this->openpay = Openpay::getInstance($merchantId, $privateKey, $location);
        
        if ($mode === 'sandbox') {
            Openpay::setProductionMode(false);
        } else {
            Openpay::setProductionMode(true);
        }
    }

    public function createCharge(string $token, float $amount, string $description, array $metadata = [], array $customer = []): array
    {
        try {
            $chargeData = [
                'source_id' => $token,
                'method' => 'card',
                'amount' => number_format($amount, 2, '.', ''),
                'currency' => 'MXN',
                'description' => $description,
                'order_id' => $metadata['order_id'] ?? uniqid('order_'),
                'device_session_id' => $metadata['device_session_id'] ?? null,
            ];

            if (!empty($customer)) {
                $chargeData['customer'] = [
                    'name' => $customer['name'] ?? '',
                    'last_name' => $customer['last_name'] ?? '',
                    'phone_number' => $customer['phone'] ?? '',
                    'email' => $customer['email'] ?? '',
                ];
            }

            $charge = $this->openpay->charges->create($chargeData);

            return [
                'success' => true,
                'id' => $charge->id,
                'status' => $charge->status,
                'amount' => $charge->amount,
                'authorization' => $charge->authorization ?? null,
                'message' => 'Pago procesado exitosamente',
            ];

        } catch (OpenpayApiRequestError $e) {
            Log::error('Openpay Request Error: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage(),
                'error_code' => $e->getErrorCode(),
            ];
        } catch (OpenpayApiAuthError $e) {
            Log::error('Openpay Auth Error: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => 'Error de autenticación con Openpay',
            ];
        } catch (\Exception $e) {
            Log::error('Openpay General Error: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => 'Error al procesar el pago: ' . $e->getMessage(),
            ];
        }
    }

    public function getCharge(string $chargeId): ?object
    {
        try {
            return $this->openpay->charges->get($chargeId);
        } catch (\Exception $e) {
            Log::error('Openpay Get Charge Error: ' . $e->getMessage());
            return null;
        }
    }

    public function refundCharge(string $chargeId, ?float $amount = null, ?string $description = null): array
    {
        try {
            $refundData = [
                'description' => $description ?? 'Reembolso',
            ];

            if ($amount) {
                $refundData['amount'] = number_format($amount, 2, '.', '');
            }

            $refund = $this->openpay->charges->refund($chargeId, $refundData);

            return [
                'success' => true,
                'id' => $refund->id,
                'message' => 'Reembolso procesado exitosamente',
            ];
        } catch (\Exception $e) {
            Log::error('Openpay Refund Error: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }
}
