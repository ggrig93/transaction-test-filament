<?php

namespace App\Filament\Resources;

use App\Actions\CreateTransaction;
use App\Enums\TransactionType;
use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Closure;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    /**
     * @param Form $form
     * @return Form
     */
    public static function form(Form $form): Form
    {
        $isCreate = $form->getOperation() === "create";

        return $form
            ->schema([
                Card::make()->schema([
                    TextInput::make('name')->reactive(),
                    TextInput::make('password')->visible($isCreate),
                    TextInput::make('email')->required(),
                ])
            ]);
    }

    /**
     * @param Table $table
     * @return Table
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable()->searchable(),
                TextColumn::make('name')->limit(20)->sortable()->searchable(),
                TextColumn::make('balance')->limit(20)->sortable()->searchable(),
            ])
            ->actions([
                Tables\Actions\Action::make(TransactionType::DEBIT->value)
                    ->form(function (User $user) {
                        return [
                            TextInput::make('amount')->rules(['numeric', 'lte:' . $user->balance])
                        ];
                    })
                    ->action(function (User $user, array $data, CreateTransaction $createTransaction): void {
                        $createTransaction($user, $data['amount']);
                    }),
                Tables\Actions\Action::make(TransactionType::CREDIT->value)
                    ->form([
                        TextInput::make('amount'),
                    ])
                    ->action(function (User $user, array $data, CreateTransaction $createTransaction): void {
                        $createTransaction($user, $data['amount'], true);
                    }),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    /**
     * @return array|\Filament\Resources\Pages\PageRegistration[]
     */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

}
