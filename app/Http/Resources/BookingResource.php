<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'              => $this->id,
            'booking_number'  => $this->booking_number,
            'customer_name'   => $this->customer_name,
            'customer_email'  => $this->customer_email,
            'customer_phone'  => $this->customer_phone,
            'bookable_type'   => class_basename($this->bookable_type),
            'bookable_id'     => $this->bookable_id,
            'bookable'        => $this->whenLoaded('bookable', fn () => [
                'name' => $this->bookable->name,
                'slug' => $this->bookable->slug,
            ]),
            'start_date'      => $this->start_date?->toDateString(),
            'end_date'        => $this->end_date?->toDateString(),
            'pickup_time'     => $this->pickup_time,
            'adults'          => $this->adults,
            'children'        => $this->children,
            'subtotal'        => (float) $this->subtotal,
            'discount'        => (float) $this->discount,
            'tax'             => (float) $this->tax,
            'total'           => (float) $this->total,
            'status'          => $this->status,
            'payment_status'  => $this->payment_status,
            'payment_method'  => $this->payment_method,
            'special_requests'=> $this->special_requests,
            'flight_number'   => $this->flight_number,
            'created_at'      => $this->created_at?->toIso8601String(),
        ];
    }
}
