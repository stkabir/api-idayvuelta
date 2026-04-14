<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Tour extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'name', 'slug', 'description', 'highlights', 'destination', 'duration',
        'max_people', 'price_adult', 'price_child', 'included', 'not_included',
        'itinerary', 'meeting_point', 'difficulty_level', 'is_active', 'featured',
        'latitude', 'longitude',
    ];

    protected $casts = [
        'max_people'       => 'integer',
        'price_adult'      => 'decimal:2',
        'price_child'      => 'decimal:2',
        'included'         => 'array',
        'not_included'     => 'array',
        'itinerary'        => 'array',
        'is_active'        => 'boolean',
        'featured'         => 'boolean',
        'latitude'         => 'float',
        'longitude'        => 'float',
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
