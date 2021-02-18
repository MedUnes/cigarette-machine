<?php

declare(strict_types=1);

namespace App\Machine;

use App\Transaction\PurchaseTransaction;
use App\Transaction\PurchaseTransactionValidator;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Machine\CigaretteMachine
 */
final class CigaretteMachineTest extends TestCase
{
    private const FAKE_CHANGE = [[2, 0], [1, 0], [0.5, 0], [0.2, 0], [0.1, 0], [0.05, 0], [0.02, 0], [0.01, 0]];
    /**
     * @var PurchaseTransactionValidator|\PHPUnit\Framework\MockObject\MockObject
     */
    private $validatorMock;
    /**
     * @var ChangeCalculator|\PHPUnit\Framework\MockObject\MockObject
     */
    private $calculatorMock;
    private array $fakeChange;

    public function setUp(): void
    {
        $this->validatorMock = $this->createMock(PurchaseTransactionValidator::class);
        $this->calculatorMock = $this->createMock(ChangeCalculator::class);
    }

    public function provideData(): array
    {
        return [
            'cancel' => ['quantity' => 0, 'amount' => 3.5, 'valid' => false, 'expected' => new PurchasedItem(0, 0, static::FAKE_CHANGE)],
            'no money' => ['quantity' => 1, 'amount' => 0.0, 'valid' => false, 'expected' => new PurchasedItem(0, 0, static::FAKE_CHANGE)],
            'very few' => ['quantity' => 1, 'amount' => 0.01, 'valid' => false, 'expected' => new PurchasedItem(0, 0, static::FAKE_CHANGE)],
            'still few' => ['quantity' => 1, 'amount' => 2.0, 'valid' => false, 'expected' => new PurchasedItem(0, 0, static::FAKE_CHANGE)],
            'close' => ['quantity' => 1, 'amount' => 4.5, 'valid' => false, 'expected' => new PurchasedItem(0, 0, static::FAKE_CHANGE)],
            'very close' => ['quantity' => 1, 'amount' => 4.98, 'valid' => false, 'expected' => new PurchasedItem(0, 0, static::FAKE_CHANGE)],
            'just enough' => ['quantity' => 1, 'amount' => 4.99, 'valid' => true, 'expected' => new PurchasedItem(1, 4.99, static::FAKE_CHANGE)],
            'a bit more' => ['quantity' => 1, 'amount' => 5.0, 'valid' => true, 'expected' => new PurchasedItem(1, 4.99, static::FAKE_CHANGE)],
            'a lot more' => ['quantity' => 1, 'amount' => 200, 'valid' => true, 'expected' => new PurchasedItem(1, 4.99, static::FAKE_CHANGE)],
            'can buy, one, but not two!' => ['amount' => 7, 'quantity' => 2, 'valid' => false, 'expected' => new PurchasedItem(0, 0, static::FAKE_CHANGE)],
            'rich man' => ['quantity' => 30, 'amount' => 200, 'valid' => true, 'expected' => new PurchasedItem(30, 149.7, static::FAKE_CHANGE)],
        ];
    }

    /**
     * @dataProvider provideData
     * @covers       \App\Machine\CigaretteMachine::execute()
     *
     * As the injected services logics are already tested in dedicated unit tests,
     * Basically the remaining logic to be tested here is the calculation of totalAmount
     */
    public function testCalculate(int $quantity, float $amount, bool $isValid, PurchasedItem $expected): void
    {
        $transaction = new PurchaseTransaction($quantity, $amount);
        $this->calculatorMock->method('calculate')->willReturn($expected->getChange());
        $this->validatorMock->method('isValid')->willReturn($isValid);

        $sut = new CigaretteMachine($this->calculatorMock, $this->validatorMock);

        $actual = $sut->execute($transaction);

        self::assertSame($expected->getItemQuantity(), $actual->getItemQuantity());
        self::assertSame($expected->getTotalAmount(), $actual->getTotalAmount());
        self::assertSame($expected->getChange(), $actual->getChange());
    }
}
