<?php

namespace App\Filament\Resources\TransactionResource\Pages;
use App\Enums\TransactionType;
use App\Filament\Resources\TransactionResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateTransaction extends CreateRecord
{
    protected static string $resource = TransactionResource::class;

    /**
     * @param array $data
     * @return Model
     */
    protected function handleRecordCreation(array $data): Model
    {
        $record = static::getModel()::create($data)->load('user');
        $userBalance = $record->user->balance;
        $amount = $data['type'] === TransactionType::DEBIT->value ? $userBalance - $data['amount'] : $userBalance + $data['amount'];
        $record->user()->update(['balance' => $amount]);

        return $record;
    }
}
