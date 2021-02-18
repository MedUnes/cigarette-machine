<?php

declare(strict_types=1);

namespace App\Machine;

use InvalidArgumentException;

class ChangeCalculator
{
    /** @var string[] */
    public const EU_COINS = [2, 1, 0.5, 0.2, 0.1, 0.05, 0.02, 0.01];

    public function calculate(float $amount): array
    {
        if ($amount < 0) {
            throw new InvalidArgumentException('The amount of money can not be a negative number!');
        }
        $change = [];
        /*
         * Will loop from biggest (2) down to smallest (0.01)
         */
        foreach (static::EU_COINS as $coin) {
            $count = $this->howMany((float)$coin, $amount);
            $change[] = [$coin, $count];
            $amount -= $count * $coin;
        }

        return $change;
    }

    private function howMany(float $coin, float $amount): int
    {
        return (int)(round($amount, 2) / round($coin, 2));
    }
}
