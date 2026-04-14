<?php

namespace App\Http\Requests;

use App\Models\Hotel;
use App\Models\Tour;
use App\Models\Transfer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBookingRequest extends FormRequest
{
    /** Acceso público — no requiere autenticación */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customer_name'    => ['required', 'string', 'max:255'],
            'customer_email'   => ['required', 'email', 'max:255'],
            'customer_phone'   => ['required', 'string', 'max:30'],
            'bookable_type'    => ['required', Rule::in(['hotel', 'tour', 'transfer'])],
            'bookable_id'      => ['required', 'integer'],
            'start_date'       => ['required', 'date', 'after_or_equal:today'],
            'end_date'         => ['nullable', 'date', 'after_or_equal:start_date'],
            'pickup_time'      => ['nullable', 'date_format:H:i'],
            'adults'           => ['required', 'integer', 'min:1', 'max:20'],
            'children'         => ['nullable', 'integer', 'min:0', 'max:20'],
            'promo_code'       => ['nullable', 'string', 'max:50'],
            'special_requests' => ['nullable', 'string', 'max:1000'],
            'flight_number'    => ['nullable', 'string', 'max:20'],
            'payment_method'   => ['nullable', Rule::in(['card', 'paypal', 'oxxo'])],
        ];
    }

    public function messages(): array
    {
        return [
            'start_date.after_or_equal' => 'La fecha de inicio debe ser hoy o en el futuro.',
            'bookable_type.in'          => 'El tipo de reserva debe ser hotel, tour o transfer.',
            'adults.min'                => 'Se requiere al menos 1 adulto.',
        ];
    }

    /**
     * Después de la validación, resolvemos el modelo real del bookable
     * y lo guardamos en el request para que el controller lo use.
     */
    public function passedValidation(): void
    {
        $map = [
            'hotel'    => Hotel::class,
            'tour'     => Tour::class,
            'transfer' => Transfer::class,
        ];

        $this->merge([
            'bookable_type_class' => $map[$this->bookable_type],
            'children'            => $this->input('children', 0),
        ]);
    }
}
