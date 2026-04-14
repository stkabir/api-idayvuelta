<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\HotelResource;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Cache;

class HotelController extends Controller
{
    /**
     * GET /api/v1/hotels
     *
     * Query params:
     *   search      – busca en name, description, city
     *   city        – ciudad exacta
     *   stars       – estrellas exactas
     *   stars_min   – mínimo de estrellas
     *   stars_max   – máximo de estrellas
     *   price_min   – precio mínimo por noche
     *   price_max   – precio máximo por noche
     *   featured    – 1 para solo destacados
     *   sort        – name|price_per_night|stars|created_at
     *   direction   – asc|desc
     *   per_page    – items por página (máx 50, default 12)
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $cacheKey = 'hotels:list:' . md5($request->getQueryString() ?? '');

        $hotels = Cache::remember($cacheKey, now()->addMinutes(5), function () use ($request) {
            $query = Hotel::active();

            if ($search = $request->input('search')) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%")
                      ->orWhere('city', 'like', "%{$search}%");
                });
            }

            if ($city = $request->input('city')) {
                $query->where('city', $city);
            }

            if ($stars = $request->input('stars')) {
                $query->where('stars', (int) $stars);
            } else {
                if ($min = $request->input('stars_min')) {
                    $query->where('stars', '>=', (int) $min);
                }
                if ($max = $request->input('stars_max')) {
                    $query->where('stars', '<=', (int) $max);
                }
            }

            if ($priceMin = $request->input('price_min')) {
                $query->where('price_per_night', '>=', (float) $priceMin);
            }
            if ($priceMax = $request->input('price_max')) {
                $query->where('price_per_night', '<=', (float) $priceMax);
            }

            if ($request->boolean('featured')) {
                $query->featured();
            }

            $allowed   = ['name', 'price_per_night', 'stars', 'created_at'];
            $sortField = in_array($request->input('sort'), $allowed) ? $request->input('sort') : null;
            $direction = $request->input('direction', 'asc') === 'desc' ? 'desc' : 'asc';

            if ($sortField) {
                $query->orderBy($sortField, $direction);
            } else {
                $query->orderByDesc('featured')->orderBy('name');
            }

            $perPage = min((int) $request->input('per_page', 12), 50);

            return $query->paginate($perPage)->withQueryString();
        });

        return HotelResource::collection($hotels);
    }

    /**
     * GET /api/v1/hotels/{slug}
     * Route model binding resuelve por slug (getRouteKeyName en Hotel).
     */
    public function show(Hotel $hotel): HotelResource
    {
        abort_if(!$hotel->is_active, 404);

        return new HotelResource($hotel);
    }
}
