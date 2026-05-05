<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'user_id',
        'amount',
        'currency',
        'payment_method',
        'openpay_id',
        'status',
        'description',
        'error_message',
        'metadata',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'metadata' => 'array',
    ];

    public const STATUS_PENDING = 'pending';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_FAILED = 'failed';
    public const STATUS_REFUNDED = 'refunded';

    public function order()
    {
        return $this->belongsTo(Booking::class, 'order_id');
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'order_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
