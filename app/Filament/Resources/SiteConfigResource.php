<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiteConfigResource\Pages;
use App\Models\SiteConfig;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SiteConfigResource extends Resource
{
    protected static ?string $model = SiteConfig::class;

    protected static ?string $navigationIcon  = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationLabel = 'Configuración del sitio';
    protected static ?string $modelLabel      = 'Configuración';
    protected static ?string $pluralModelLabel = 'Configuración';
    protected static ?int    $navigationSort  = 99;

    public static function form(Form $form): Form
    {
        return $form->schema([

            Forms\Components\Section::make('Marca')
                ->description('Nombre, tagline y URL del sitio')
                ->icon('heroicon-o-building-storefront')
                ->schema([
                    Forms\Components\TextInput::make('brand_name')
                        ->label('Nombre del sitio')
                        ->required()
                        ->maxLength(100),
                    Forms\Components\TextInput::make('brand_tagline')
                        ->label('Tagline / Eslogan')
                        ->maxLength(200),
                    Forms\Components\TextInput::make('site_url')
                        ->label('URL del sitio')
                        ->url()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('logo_url')
                        ->label('URL del logo (SVG o PNG)')
                        ->url()
                        ->placeholder('https://...')
                        ->maxLength(500),
                    Forms\Components\TextInput::make('favicon_url')
                        ->label('URL del favicon')
                        ->url()
                        ->placeholder('https://...')
                        ->maxLength(500),
                ])->columns(2),

            Forms\Components\Section::make('Colores')
                ->description('Colores principales del sitio (formato hex)')
                ->icon('heroicon-o-swatch')
                ->schema([
                    Forms\Components\ColorPicker::make('color_primary')
                        ->label('Color primario'),
                    Forms\Components\ColorPicker::make('color_secondary')
                        ->label('Color secundario'),
                    Forms\Components\ColorPicker::make('color_accent')
                        ->label('Color de acento'),
                ])->columns(3),

            Forms\Components\Section::make('Servicios habilitados')
                ->description('Activa o desactiva los módulos del sitio')
                ->icon('heroicon-o-squares-2x2')
                ->schema([
                    Forms\Components\Toggle::make('service_hotels')
                        ->label('Hoteles')
                        ->onColor('success')
                        ->inline(false),
                    Forms\Components\Toggle::make('service_tours')
                        ->label('Tours y Actividades')
                        ->onColor('success')
                        ->inline(false),
                    Forms\Components\Toggle::make('service_transfers')
                        ->label('Traslados')
                        ->onColor('success')
                        ->inline(false),
                ])->columns(3),

            Forms\Components\Section::make('Ubicación y SEO')
                ->description('Información del destino para buscadores')
                ->icon('heroicon-o-map-pin')
                ->schema([
                    Forms\Components\TextInput::make('location_name')
                        ->label('Nombre del destino')
                        ->maxLength(150),
                    Forms\Components\TextInput::make('location_region')
                        ->label('Región / Estado')
                        ->maxLength(100),
                    Forms\Components\TextInput::make('location_country')
                        ->label('País')
                        ->maxLength(100),
                    Forms\Components\Textarea::make('location_desc')
                        ->label('Descripción del destino')
                        ->rows(2)
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('seo_keywords')
                        ->label('Keywords SEO (separadas por coma)')
                        ->placeholder('tours cancun, hoteles riviera maya, traslado aeropuerto')
                        ->columnSpanFull(),
                ])->columns(3),

            Forms\Components\Section::make('Contacto')
                ->description('Datos de contacto que aparecen en el sitio')
                ->icon('heroicon-o-phone')
                ->schema([
                    Forms\Components\TextInput::make('whatsapp')
                        ->label('WhatsApp (con código de país)')
                        ->placeholder('+52 998 123 4567')
                        ->tel(),
                    Forms\Components\TextInput::make('phone')
                        ->label('Teléfono')
                        ->placeholder('+52 998 123 4567')
                        ->tel(),
                    Forms\Components\TextInput::make('email')
                        ->label('Email de contacto')
                        ->email(),
                    Forms\Components\TextInput::make('address')
                        ->label('Dirección')
                        ->columnSpanFull(),
                ])->columns(3),

            Forms\Components\Section::make('Redes Sociales')
                ->description('URLs completas de los perfiles (dejar vacío para ocultar)')
                ->icon('heroicon-o-share')
                ->schema([
                    Forms\Components\TextInput::make('social_facebook')
                        ->label('Facebook')
                        ->url()
                        ->placeholder('https://facebook.com/tupagina'),
                    Forms\Components\TextInput::make('social_instagram')
                        ->label('Instagram')
                        ->url()
                        ->placeholder('https://instagram.com/tuperfil'),
                    Forms\Components\TextInput::make('social_twitter')
                        ->label('Twitter / X')
                        ->url()
                        ->placeholder('https://x.com/tuperfil'),
                ])->columns(3),

            Forms\Components\Section::make('Funcionalidades y Analytics')
                ->icon('heroicon-o-chart-bar')
                ->schema([
                    Forms\Components\Toggle::make('enable_promo_codes')
                        ->label('Códigos promocionales')
                        ->onColor('success')
                        ->inline(false),
                    Forms\Components\TextInput::make('ga_id')
                        ->label('Google Analytics ID')
                        ->placeholder('G-XXXXXXXXXX'),
                    Forms\Components\TextInput::make('fb_pixel')
                        ->label('Facebook Pixel ID')
                        ->placeholder('123456789'),
                ])->columns(3),

        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('brand_name')
                    ->label('Nombre del sitio')
                    ->searchable(),
                Tables\Columns\TextColumn::make('site_url')
                    ->label('URL')
                    ->url(fn ($record) => $record->site_url)
                    ->openUrlInNewTab(),
                Tables\Columns\IconColumn::make('service_hotels')
                    ->label('Hoteles')
                    ->boolean(),
                Tables\Columns\IconColumn::make('service_tours')
                    ->label('Tours')
                    ->boolean(),
                Tables\Columns\IconColumn::make('service_transfers')
                    ->label('Traslados')
                    ->boolean(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Última actualización')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Editar'),
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSiteConfigs::route('/'),
            'edit'  => Pages\EditSiteConfig::route('/{record}/edit'),
        ];
    }
}
