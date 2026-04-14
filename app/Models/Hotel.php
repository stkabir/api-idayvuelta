<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Hotel extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'name', 'slug', 'description', 'address', 'city', 'state', 'country',
        'stars', 'price_per_night', 'amenities', 'is_active', 'featured',
        'latitude', 'longitude',
    ];

    protected $casts = [
        'stars'           => 'integer',
        'price_per_night' => 'decimal:2',
        'amenities'       => 'array',
        'is_active'       => 'boolean',
        'featured'        => 'boolean',
        'latitude'        => 'float',
        'longitude'       => 'float',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    // ─── Relationships ───────────────────────────────────────────────────────

    public function bookings(): MorphMany
    {
        return $this->morphMany(Booking::class, 'bookable');
    }

    // ─── Scopes ──────────────────────────────────────────────────────────────

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('featured', true);
    }

    // ─── Media Library ───────────────────────────────────────────────────────

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images');
        $this->addMediaCollection('cover')->singleFile();
    }
}
