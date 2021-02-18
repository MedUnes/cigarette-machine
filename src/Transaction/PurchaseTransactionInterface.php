<?php

declare(strict_types=1);

namespace App\Transaction;

/** @codeCoverageIgnore  */
interface PurchaseTransactionInterface
{
    public function getItemQuantity(): int;

    public function getPaidAmount(): float;
}
