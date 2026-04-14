<?php

namespace App\Observers;

use App\Models\Tour;
use Illuminate\Support\Facades\Cache;

class TourObserver
{
    public function saved(Tour $tour): void
    {
        Cache::flush();
    }

    public function deleted(Tour $tour): void
    {
        Cache::flush();
    }
}
