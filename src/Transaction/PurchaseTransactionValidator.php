<?php

declare(strict_types=1);

namespace App\Transaction;

use App\Machine\CigaretteMachine;

class PurchaseTransactionValidator
{
    public function isValid(PurchaseTransactionInterface $transaction): bool
    {
        /*
         * This can be considered as a "cancel". Hence, return all the money!
         */
        if ($transaction->getItemQuantity() === 0) {
            return false;
        }
        if ($transaction->getPaidAmount() < $transaction->getItemQuantity() * CigaretteMachine::ITEM_PRICE) {
            return false;
        }

        return true;
    }
}
