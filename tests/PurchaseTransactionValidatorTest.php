<?php

declare(strict_types=1);

namespace App\Transaction;

use PHPUnit\Framework\TestCase;

/**
 * @covers       \App\Transaction\PurchaseTransactionValidator
 */
final class PurchaseTransactionValidatorTest extends TestCase
{
    public function provideData(): array
    {
        return [
            'cancel' => ['quantity' => 0, 'amount' => 3.5, 'expected' => false],
            'no money' => ['quantity' => 1, 'amount' => 0.0, 'expected' => false],
            'very few' => ['quantity' => 1, 'amount' => 0.01, 'expected' => false],
            'still few' => ['quantity' => 1, 'amount' => 2.0, 'expected' => false],
            'close' => ['quantity' => 1, 'amount' => 4.5, 'expected' => false],
            'very close' => ['quantity' => 1, 'amount' => 4.98, 'expected' => false],
            'just enough' => ['quantity' => 1, 'amount' => 4.99, 'expected' => true],
            'a bit more' => ['quantity' => 1, 'amount' => 5.0, 'expected' => true],
            'a lot more' => ['quantity' => 1, 'amount' => 200, 'expected' => true],
            'can buy, one, but not two!' => ['quantity' => 2, 'amount' => 5, 'expected' => false],
            'rich man' => ['quantity' => 30, 'amount' => 200, 'expected' => true],
        ];
    }

    /**
     * @dataProvider provideData
     * @covers       \App\Transaction\PurchaseTransactionValidator::isValid()
     */
    public function testCalculate(int $quantity, float $amount, bool $expected): void
    {
        $sut = new PurchaseTransactionValidator();
        $transaction = new PurchaseTransaction($quantity, $amount);

        $actual = $sut->isValid($transaction);
        self::assertSame($expected, $actual);
    }
}
