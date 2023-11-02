<?php

declare(strict_types=1);

namespace Dakulov\BellTest\Model;

class ClassicEmitter implements Emitter
{
    public function __construct(
        private readonly Randomizer $randomizer,
    ) {
    }

    /**
     * @throws \Exception
     */
    public function emit(): array
    {
        do {
            $a = $this->getRandomSpin();
            $b = $this->getRandomSpin();
            $c = $this->getRandomSpin();
        } while ($a === $b && $b === $c);

        return [
            new ClassicParticle($a, $b, $c),
            new ClassicParticle($a->getOpposite(), $b->getOpposite(), $c->getOpposite()),
        ];
    }

    /**
     * @throws \Exception
     */
    private function getRandomSpin(): Spin
    {
        return match ($this->randomizer->getInt(0, 1)) {
            0 => Spin::UP,
            1 => Spin::DOWN,
        };
    }
}
