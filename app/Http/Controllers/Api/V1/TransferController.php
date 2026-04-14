<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\TransferResource;
use App\Models\Transfer;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Cache;

class TransferController extends Controller
{
    /**
     * GET /api/v1/transfers
     *
     * Query params:
     *   search          – busca en name, description, from_location, to_location
     *   type            – one-way|round-trip
     *   vehicle_type    – sedan|suv|van|bus
     *   min_passengers  – capacidad mínima requerida
     *   featured        – 1 para solo destacados
     *   price_min       – precio mínimo
     *   price_max       – precio máximo
     *   sort            – name|price|max_passengers|created_at
     *   direction       – asc|desc
     *   per_page        – items por página (máx 50, default 12)
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $cacheKey = 'transfers:list:' . md5($request->getQueryString() ?? '');

        $transfers = Cache::remember($cacheKey, now()->addMinutes(5), function () use ($request) {
            $query = Transfer::active();

            if ($search = $request->input('search')) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%")
                      ->orWhere('from_location', 'like', "%{$search}%")
                      ->orWhere('to_location', 'like', "%{$search}%");
                });
            }

            if ($type = $request->input('type')) {
                $query->where('type', $type);
            }

            if ($vehicleType = $request->input('vehicle_type')) {
                $query->where('vehicle_type', $vehicleType);
            }

            if ($minPassengers = $request->input('min_passengers')) {
                $query->where('max_passengers', '>=', (int) $minPassengers);
            }

            if ($priceMin = $request->input('price_min')) {
                $query->where('price', '>=', (float) $priceMin);
            }
            if ($priceMax = $request->input('price_max')) {
                $query->where('price', '<=', (float) $priceMax);
            }

            if ($request->boolean('featured')) {
                $query->featured();
            }

            $allowed   = ['name', 'price', 'max_passengers', 'created_at'];
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

        return TransferResource::collection($transfers);
    }

    /**
     * GET /api/v1/transfers/{slug}
     */
    public function show(Transfer $transfer): TransferResource
    {
        abort_if(!$transfer->is_active, 404);

        return new TransferResource($transfer);
    }
}
