<?php

namespace App\Providers;

use App\Models\Banner;
use App\Models\Hotel;
use App\Models\Tour;
use App\Models\Transfer;
use App\Observers\BannerObserver;
use App\Observers\HotelObserver;
use App\Observers\TourObserver;
use App\Observers\TransferObserver;
use App\Services\BookingService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(BookingService::class);
    }

    public function boot(): void
    {
        Hotel::observe(HotelObserver::class);
        Tour::observe(TourObserver::class);
        Transfer::observe(TransferObserver::class);
        Banner::observe(BannerObserver::class);
    }
}
