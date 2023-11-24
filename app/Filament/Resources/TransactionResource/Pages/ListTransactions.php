<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use App\Enums\TransactionType;
use App\Filament\Resources\TransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Model;

class ListTransactions extends ListRecords
{
    protected static string $resource = TransactionResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $record = static::getModel()::create($data)->load('user');
        $userBalance = $record->user->balance;
        $amount = $data['type'] === TransactionType::DEBIT->value ? $userBalance - $data['amount'] : $userBalance + $data['amount'];

        $record->user()->update(['balance' => $amount]);

        return $record;
    }
}
