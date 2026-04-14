<?php

namespace App\Observers;

use App\Models\Transfer;
use Illuminate\Support\Facades\Cache;

class TransferObserver
{
    public function saved(Transfer $transfer): void
    {
        Cache::flush();
    }

    public function deleted(Transfer $transfer): void
    {
        Cache::flush();
    }
}
