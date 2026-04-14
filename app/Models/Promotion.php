<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'code', 'description', 'discount_type', 'discount_value',
        'start_date', 'end_date', 'usage_limit', 'used_count', 'min_purchase',
        'is_active', 'applicable_type', 'applicable_id',
    ];

    protected $casts = [
        'discount_value' => 'decimal:2',
        'start_date'     => 'date',
        'end_date'       => 'date',
        'usage_limit'    => 'integer',
        'used_count'     => 'integer',
        'min_purchase'   => 'decimal:2',
        'is_active'      => 'boolean',
    ];

    // ─── Relationships ───────────────────────────────────────────────────────

    public function applicable(): MorphTo
    {
        return $this->morphTo();
    }

    // ─── Scopes ──────────────────────────────────────────────────────────────

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /** Promo activa, dentro de fechas y sin exceder el límite de uso */
    public function scopeValid(Builder $query): Builder
    {
        return $query->active()
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->where(function (Builder $q) {
                $q->whereNull('usage_limit')
                  ->orWhereRaw('used_count < usage_limit');
            });
    }

    // ─── Helpers ─────────────────────────────────────────────────────────────

    public function isValid(): bool
    {
        if (!$this->is_active) return false;
        if (now()->lt($this->start_date) || now()->gt($this->end_date)) return false;
        if ($this->usage_limit && $this->used_count >= $this->usage_limit) return false;
        return true;
    }

    public function calculateDiscount(float $subtotal): float
    {
        if ($this->discount_type === 'percentage') {
            return round($subtotal * ($this->discount_value / 100), 2);
        }
        return min((float) $this->discount_value, $subtotal);
    }
}
