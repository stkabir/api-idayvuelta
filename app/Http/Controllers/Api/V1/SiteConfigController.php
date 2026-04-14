<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\SiteConfigResource;
use App\Models\SiteConfig;
use Illuminate\Http\JsonResponse;

class SiteConfigController extends Controller
{
    public function show(): JsonResponse
    {
        $config = SiteConfig::instance();

        return response()->json(new SiteConfigResource($config));
    }
}
