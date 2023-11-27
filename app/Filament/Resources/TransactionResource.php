<?php

namespace App\Filament\Resources;
use App\Filament\Resources\TransactionResource\Pages;
use App\Models\Transaction;
use Filament\Actions\Action;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('amount')->sortable()->searchable(),
                TextColumn::make('type')->sortable()->searchable(),
                TextColumn::make('user.name')->sortable()->searchable()->label('name'),
                TextColumn::make('user.email')->sortable()->searchable()->label('email'),
            ]);

    }

    /**
     * @return array|\Filament\Resources\Pages\PageRegistration[]
     */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }

    /**
     * @return bool
     */
    public static function canCreate(): bool
    {
        return false;
    }

    /**
     * @param Model $record
     * @return bool
     */
    public static function canEdit(Model $record): bool
    {
        return false;
    }

    /**
     * @param Model $record
     * @return bool
     */
    public static function canDelete(Model $record): bool
    {
        return false;
    }
}
