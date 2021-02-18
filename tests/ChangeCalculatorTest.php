<?php

declare(strict_types=1);

namespace App\Machine;

use PHPUnit\Framework\TestCase;

/**
 * @dataProvider provideData
 * @covers \App\Machine\ChangeCalculator
 */
final class ChangeCalculatorTest extends TestCase
{
    public function provideData(): array
    {
        return [
            'noMoney' => ['amount' => 0, 'change' => [[2, 0], [1, 0], [0.5, 0], [0.2, 0], [0.1, 0], [0.05, 0], [0.02, 0], [0.01, 0]]],
            'few' => ['amount' => 0.01, 'change' => [[2, 0], [1, 0], [0.5, 0], [0.2, 0], [0.1, 0], [0.05, 0], [0.02, 0], [0.01, 1]]],
            'a bit more' => ['amount' => 0.7, 'change' => [[2, 0], [1, 0], [0.5, 1], [0.2, 1], [0.1, 0], [0.05, 0], [0.02, 0], [0.01, 0]]],
            'a bit bit more' => ['amount' => 0.9, 'change' => [[2, 0], [1, 0], [0.5, 1], [0.2, 2], [0.1, 0], [0.05, 0], [0.02, 0], [0.01, 0]]],
            'almost one' => ['amount' => 0.99, 'change' => [[2, 0], [1, 0], [0.5, 1], [0.2, 2], [0.1, 0], [0.05, 1], [0.02, 2], [0.01, 0]]],
            'one' => ['amount' => 1.0, 'change' => [[2, 0], [1, 1], [0.5, 0], [0.2, 0], [0.1, 0], [0.05, 0], [0.02, 0], [0.01, 0]]],
            'all coins in the change!' => ['amount' => 3.88, 'change' => [[2, 1], [1, 1], [0.5, 1], [0.2, 1], [0.1, 1], [0.05, 1], [0.02, 1], [0.01, 1]]],
            'all coins in the change having some > 1 dups!' => ['amount' => 7.88, 'change' => [[2, 3], [1, 1], [0.5, 1], [0.2, 1], [0.1, 1], [0.05, 1], [0.02, 1], [0.01, 1]]],
        ];
    }

    /**
     * @dataProvider provideData
     * @covers       \App\Machine\ChangeCalculator::calculate()
     */
    public function testCalculate(float $amount, array $expected): void
    {
        $sut = new ChangeCalculator();
        $actual = $sut->calculate($amount);
        self::assertSame($expected, $actual);
    }
}
