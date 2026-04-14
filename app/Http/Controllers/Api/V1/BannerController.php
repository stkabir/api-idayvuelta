<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\BannerResource;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Cache;

class BannerController extends Controller
{
    /**
     * GET /api/v1/banners
     *
     * Query params:
     *   position – home|hotels|tours|transfers (default: home)
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $position = $request->input('position', 'home');
        $cacheKey = "banners:{$position}";

        $banners = Cache::remember($cacheKey, now()->addMinutes(10), function () use ($position) {
            return Banner::active()
                ->forPosition($position)
                ->orderBy('order')
                ->get();
        });

        return BannerResource::collection($banners);
    }
}
