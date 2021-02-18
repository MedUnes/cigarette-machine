<?php

declare(strict_types=1);

namespace App\Machine;

use App\Transaction\PurchaseTransactionInterface;
use App\Transaction\PurchaseTransactionValidator;

class CigaretteMachine implements MachineInterface
{
    public const ITEM_PRICE = 4.99;
    private ChangeCalculator $calculator;
    private PurchaseTransactionValidator $validator;

    public function __construct(ChangeCalculator $calculator, PurchaseTransactionValidator $validator)
    {
        $this->calculator = $calculator;
        $this->validator = $validator;
    }

    public function execute(PurchaseTransactionInterface $purchaseTransaction): PurchasedItem
    {
        $itemQuantity = $this->validator->isValid($purchaseTransaction) ? $purchaseTransaction->getItemQuantity() : 0;
        $totalAmount = $itemQuantity * static::ITEM_PRICE;
        $remainder = $purchaseTransaction->getPaidAmount() - $totalAmount;

        return new PurchasedItem(
            $itemQuantity,
            $totalAmount,
            $this->calculator->calculate($remainder)
        );
    }
}
