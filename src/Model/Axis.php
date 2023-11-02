<?php

declare(strict_types=1);

namespace Dakulov\BellTest\Model;

/**
 * For this task we need three axes: A, B, C (120 degrees between each other).
 */
enum Axis
{
    case A;
    case B;
    case C;

    /**
     * @return float - angle relatively to direction ↑ (UP) in degrees.
     */
    public function getAngle(): float
    {
        return match ($this) {
            self::A => 0.0,
            self::B => 120.0,
            self::C => 240.0,
        };
    }
}
