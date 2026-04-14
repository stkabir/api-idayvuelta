<?php

namespace App\Filament\Resources\SiteConfigResource\Pages;

use App\Filament\Resources\SiteConfigResource;
use App\Models\SiteConfig;
use Filament\Resources\Pages\ListRecords;

class ListSiteConfigs extends ListRecords
{
    protected static string $resource = SiteConfigResource::class;

    // Redirige directo al formulario de edición (es un singleton)
    public function mount(): void
    {
        $config = SiteConfig::instance();
        $this->redirect(SiteConfigResource::getUrl('edit', ['record' => $config]));
    }

    protected function getHeaderActions(): array
    {
        return []; // Sin botón "Crear nuevo"
    }
}
