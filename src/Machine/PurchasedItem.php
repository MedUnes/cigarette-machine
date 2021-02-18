<?php

declare(strict_types=1);

namespace App\Machine;

/** @codeCoverageIgnore  */
class PurchasedItem implements PurchasedItemInterface
{
    private int $itemQuantity;
    private float $totalAmount;
    private array $change;

    public function __construct(int $itemQuantity, float $totalAmount, array $change)
    {
        $this->itemQuantity = $itemQuantity;
        $this->totalAmount = $totalAmount;
        $this->change = $change;
    }

    public function getItemQuantity(): int
    {
        return $this->itemQuantity;
    }

    public function getTotalAmount(): float
    {
        return $this->totalAmount;
    }

    public function getChange(): array
    {
        return $this->change;
    }
}
