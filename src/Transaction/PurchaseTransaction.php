<?php

declare(strict_types=1);


namespace App\Transaction;

/** @codeCoverageIgnore  */
class PurchaseTransaction implements PurchaseTransactionInterface
{
    private int $itemQuantity;
    private float $paidAmount;

    public function __construct(int $itemQuantity, float $paidAmount)
    {
        $this->itemQuantity = $itemQuantity;
        $this->paidAmount = $paidAmount;
    }

    public function getItemQuantity(): int
    {
        return $this->itemQuantity;
    }

    public function getPaidAmount(): float
    {
        return $this->paidAmount;
    }


}
