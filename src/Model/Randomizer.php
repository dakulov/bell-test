<?php

declare(strict_types=1);

namespace Dakulov\BellTest\Model;

/**
 * @infection-ignore-all
 */
class Randomizer
{
    private const MULTIPLIER = 1_000_000;

    /**
     * @throws \Exception
     */
    public function getInt(int $min, int $max): int
    {
        return random_int($min, $max);
    }

    /**
     * @throws \Exception
     */
    public function getBool(float $probability): bool
    {
        return $this->getInt(1, self::MULTIPLIER) <= $probability * self::MULTIPLIER;
    }
}
