<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ValidatePromoCodeRequest;
use App\Services\BookingService;
use Illuminate\Http\JsonResponse;

class PromotionController extends Controller
{
    public function __construct(private readonly BookingService $bookingService)
    {
    }

    /**
     * POST /api/v1/promotions/validate
     * Valida un código promocional y devuelve el descuento calculado.
     *
     * Body: { code: "VERANO2026", subtotal: 1200 }
     */
    public function validateCode(ValidatePromoCodeRequest $request): JsonResponse
    {
        $result = $this->bookingService->validatePromoCode(
            $request->input('code'),
            (float) $request->input('subtotal')
        );

        if (!$result['valid']) {
            return response()->json([
                'valid'   => false,
                'message' => $result['message'],
            ], 422);
        }

        return response()->json([
            'valid'           => true,
            'message'         => $result['message'],
            'discount_type'   => $result['discount_type'],
            'discount_value'  => $result['discount_value'],
            'discount_amount' => $result['discount_amount'],
        ]);
    }
}
