<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Transfer extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'name', 'slug', 'description', 'from_location', 'to_location', 'type',
        'vehicle_type', 'max_passengers', 'price', 'is_private', 'features',
        'is_active', 'featured',
    ];

    protected $casts = [
        'max_passengers' => 'integer',
        'price'          => 'decimal:2',
        'is_private'     => 'boolean',
        'features'       => 'array',
        'is_active'      => 'boolean',
        'featured'       => 'boolean',
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
