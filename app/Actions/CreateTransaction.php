<?php

namespace App\Actions;

use App\Enums\TransactionType;
use App\Models\User;

class CreateTransaction
{
    /**
     * @param User $user
     * @param float $amount
     * @param $credit
     * @return void
     */
    public function __invoke(User $user, float $amount, $credit = false)
    {
        $user->transactions()->create([
            'type' => TransactionType::CREDIT->value,
            'amount' => $amount,
        ]);

        $credit ? $user->addBalance($amount) :  $user->subBalance($amount);
    }
}
