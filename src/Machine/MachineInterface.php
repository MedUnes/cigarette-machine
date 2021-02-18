<?php

declare(strict_types=1);


namespace App\Machine;

use App\Transaction\PurchaseTransactionInterface;

/** @codeCoverageIgnore  */
interface MachineInterface
{
    public function execute(PurchaseTransactionInterface $purchaseTransaction): PurchasedItemInterface;
}
