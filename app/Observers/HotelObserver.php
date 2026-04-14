<?php

namespace App\Observers;

use App\Models\Hotel;
use Illuminate\Support\Facades\Cache;

class HotelObserver
{
    public function saved(Hotel $hotel): void
    {
        $this->clearCache();
    }

    public function deleted(Hotel $hotel): void
    {
        $this->clearCache();
    }

    private function clearCache(): void
    {
        // Borrar todas las entradas de cache de hotels (por prefijo de key)
        // Con file/database driver solo podemos hacer flush total o borrar por key exacta.
        // Para producción con Redis usa: Cache::tags(['hotels'])->flush()
        Cache::flush();
    }
}
