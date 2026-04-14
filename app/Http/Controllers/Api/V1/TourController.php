<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\TourResource;
use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Cache;

class TourController extends Controller
{
    /**
     * GET /api/v1/tours
     *
     * Query params:
     *   search      – busca en name, description, destination
     *   destination – destino exacto
     *   difficulty  – easy|moderate|hard
     *   price_min   – precio mínimo por adulto
     *   price_max   – precio máximo por adulto
     *   featured    – 1 para solo destacados
     *   sort        – name|price_adult|created_at
     *   direction   – asc|desc
     *   per_page    – items por página (máx 50, default 12)
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $cacheKey = 'tours:list:' . md5($request->getQueryString() ?? '');

        $tours = Cache::remember($cacheKey, now()->addMinutes(5), function () use ($request) {
            $query = Tour::active();

            if ($search = $request->input('search')) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%")
                      ->orWhere('destination', 'like', "%{$search}%");
                });
            }

            if ($destination = $request->input('destination')) {
                $query->where('destination', $destination);
            }

            if ($difficulty = $request->input('difficulty')) {
                $query->where('difficulty_level', $difficulty);
            }

            if ($priceMin = $request->input('price_min')) {
                $query->where('price_adult', '>=', (float) $priceMin);
            }
            if ($priceMax = $request->input('price_max')) {
                $query->where('price_adult', '<=', (float) $priceMax);
            }

            if ($request->boolean('featured')) {
                $query->featured();
            }

            $allowed   = ['name', 'price_adult', 'created_at'];
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

        return TourResource::collection($tours);
    }

    /**
     * GET /api/v1/tours/{slug}
     */
    public function show(Tour $tour): TourResource
    {
        abort_if(!$tour->is_active, 404);

        return new TourResource($tour);
    }
}
