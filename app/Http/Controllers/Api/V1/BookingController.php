<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use App\Services\BookingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class BookingController extends Controller
{
    public function __construct(private readonly BookingService $bookingService)
    {
    }

    /**
     * POST /api/v1/bookings
     * Crear una reserva (no requiere autenticación).
     */
    public function store(StoreBookingRequest $request): JsonResponse
    {
        $data = array_merge($request->validated(), [
            'bookable_type_class' => $request->bookable_type_class,
        ]);

        $booking = $this->bookingService->createBooking($data);

        return (new BookingResource($booking->load('bookable')))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * GET /api/v1/bookings/{booking_number}
     * Consultar una reserva por su número (para la página de confirmación).
     */
    public function show(string $bookingNumber): BookingResource
    {
        $booking = Booking::with('bookable')
            ->where('booking_number', $bookingNumber)
            ->firstOrFail();

        return new BookingResource($booking);
    }
}
