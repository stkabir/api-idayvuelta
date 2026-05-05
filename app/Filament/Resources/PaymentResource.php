<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentResource\Pages;
use App\Models\Payment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';
    
    protected static ?string $navigationGroup = 'Ventas';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('order_id')
                    ->label('ID Reserva')
                    ->disabled(),
                Forms\Components\TextInput::make('amount')
                    ->label('Monto')
                    ->prefix('$')
                    ->disabled(),
                Forms\Components\TextInput::make('currency')
                    ->disabled(),
                Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'Pendiente',
                        'completed' => 'Completado',
                        'failed' => 'Fallido',
                        'refunded' => 'Reembolsado',
                    ]),
                Forms\Components\TextInput::make('payment_method')
                    ->disabled(),
                Forms\Components\TextInput::make('openpay_id')
                    ->label('ID OpenPay')
                    ->disabled(),
                Forms\Components\Textarea::make('error_message')
                    ->label('Error')
                    ->disabled()
                    ->visible(fn ($record) => $record && $record->error_message),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable(),
                Tables\Columns\TextColumn::make('booking.booking_number')
                    ->label('Reserva')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('booking.customer_name')
                    ->label('Cliente')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('amount')
                    ->money('MXN')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'completed' => 'success',
                        'pending' => 'warning',
                        'failed' => 'danger',
                        'refunded' => 'info',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'completed' => 'Completado',
                        'pending' => 'Pendiente',
                        'failed' => 'Fallido',
                        'refunded' => 'Reembolsado',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('payment_method')
                    ->label('Método'),
                Tables\Columns\TextColumn::make('openpay_id')
                    ->label('ID OpenPay')
                    ->copyable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pendiente',
                        'completed' => 'Completado',
                        'failed' => 'Fallido',
                        'refunded' => 'Reembolsado',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                // Sin delete bulk para mantener registro de pagos
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPayments::route('/'),
            'view' => Pages\ViewPayment::route('/{record}'),
        ];
    }
}
