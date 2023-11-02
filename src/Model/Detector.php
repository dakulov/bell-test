<?php

declare(strict_types=1);

namespace Dakulov\BellTest\Model;

class Detector
{
    public function __construct(
        private readonly Randomizer $randomizer,
    ) {
    }

    /**
     * @throws \Exception
     */
    public function measure(Particle $particle): Spin
    {
        $axis = match ($this->randomizer->getInt(0, 2)) {
            0 => Axis::A,
            1 => Axis::B,
            2 => Axis::C,
        };

        return $particle->getSpin($axis);
    }
}
