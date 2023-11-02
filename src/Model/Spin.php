<?php

declare(strict_types=1);

namespace Dakulov\BellTest\Model;

enum Spin
{
    case UP;
    case DOWN;

    public function getOpposite(): self
    {
        return match ($this) {
            self::UP => self::DOWN,
            self::DOWN => self::UP,
        };
    }
}
