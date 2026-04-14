<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Promotion;
use Illuminate\Support\Facades\DB;

class BookingService
{
    private const TAX_RATE = 0.16;

    /**
     * Crea y persiste una reserva completa dentro de una transacción.
     */
    public function createBooking(array $data): Booking
    {
        return DB::transaction(function () use ($data) {
            // Resolver el modelo bookable (Hotel, Tour o Transfer)
            $bookableClass = $data['bookable_type_class'];
            $bookable = $bookableClass::active()->findOrFail($data['bookable_id']);

            // Calcular precios
            $totals = $this->calculateTotal($data, $bookable);

            // Aplicar código promo si viene
            $discount = 0;
            $promoCode = null;
            if (!empty($data['promo_code'])) {
                $promoResult = $this->validatePromoCode($data['promo_code'], $totals['subtotal']);
                if ($promoResult['valid']) {
                    $discount = $promoResult['discount_amount'];
                    $promoCode = $promoResult['promotion'];
                }
            }

            $afterDiscount = $totals['subtotal'] - $discount;
            $tax   = round($afterDiscount * self::TAX_RATE, 2);
            $total = round($afterDiscount + $tax, 2);

            // Crear booking
            $booking = Booking::create([
                'booking_number'   => $this->generateBookingNumber(),
                'user_id'          => auth()->id(),
                'customer_name'    => $data['customer_name'],
                'customer_email'   => $data['customer_email'],
                'customer_phone'   => $data['customer_phone'],
                'bookable_type'    => $bookableClass,
                'bookable_id'      => $bookable->id,
                'start_date'       => $data['start_date'],
                'end_date'         => $data['end_date'] ?? null,
                'pickup_time'      => $data['pickup_time'] ?? null,
                'adults'           => $data['adults'],
                'children'         => $data['children'] ?? 0,
                'subtotal'         => $totals['subtotal'],
                'discount'         => $discount,
                'tax'              => $tax,
                'total'            => $total,
                'status'           => 'pending',
                'payment_status'   => 'pending',
                'payment_method'   => $data['payment_method'] ?? null,
                'special_requests' => $data['special_requests'] ?? null,
                'flight_number'    => $data['flight_number'] ?? null,
            ]);

            // Incrementar uso del código promo
            if ($promoCode) {
                $promoCode->increment('used_count');
            }

            return $booking;
        });
    }

    /**
     * Valida un código promocional y calcula el descuento.
     *
     * @return array{valid: bool, message: string, discount_amount: float, promotion: ?Promotion}
     */
    public function validatePromoCode(string $code, float $subtotal): array
    {
        $promotion = Promotion::valid()
            ->where('code', strtoupper(trim($code)))
            ->first();

        if (!$promotion) {
            return ['valid' => false, 'message' => 'Código de descuento inválido o expirado.', 'discount_amount' => 0, 'promotion' => null];
        }

        if ($promotion->min_purchase && $subtotal < $promotion->min_purchase) {
            return [
                'valid'   => false,
                'message' => "El monto mínimo para usar este código es $" . number_format($promotion->min_purchase, 2) . " MXN.",
                'discount_amount' => 0,
                'promotion' => null,
            ];
        }

        $discountAmount = $promotion->calculateDiscount($subtotal);

        return [
            'valid'           => true,
            'message'         => 'Código aplicado correctamente.',
            'discount_amount' => $discountAmount,
            'discount_type'   => $promotion->discount_type,
            'discount_value'  => (float) $promotion->discount_value,
            'promotion'       => $promotion,
        ];
    }

    /**
     * Calcula el subtotal según el tipo de servicio.
     */
    public function calculateTotal(array $data, mixed $bookable): array
    {
        $subtotal = match (class_basename($bookable)) {
            'Hotel'    => $this->calcHotelSubtotal($data, $bookable),
            'Tour'     => $this->calcTourSubtotal($data, $bookable),
            'Transfer' => (float) $bookable->price,
            default    => 0,
        };

        return ['subtotal' => round($subtotal, 2)];
    }

    private function calcHotelSubtotal(array $data, mixed $hotel): float
    {
        if (empty($data['end_date'])) {
            return (float) $hotel->price_per_night;
        }
        $nights = \Carbon\Carbon::parse($data['start_date'])
            ->diffInDays(\Carbon\Carbon::parse($data['end_date']));
        return $nights > 0 ? $nights * (float) $hotel->price_per_night : (float) $hotel->price_per_night;
    }

    private function calcTourSubtotal(array $data, mixed $tour): float
    {
        $adults   = (int) ($data['adults'] ?? 1);
        $children = (int) ($data['children'] ?? 0);
        return ($adults * (float) $tour->price_adult) + ($children * (float) ($tour->price_child ?? 0));
    }

    /**
     * Genera un número de reserva único con formato BKG-YYYYMMDD-XXXX.
     */
    public function generateBookingNumber(): string
    {
        do {
            $number = 'BKG-' . now()->format('Ymd') . '-' . strtoupper(substr(uniqid(), -4));
        } while (Booking::where('booking_number', $number)->exists());

        return $number;
    }
}
