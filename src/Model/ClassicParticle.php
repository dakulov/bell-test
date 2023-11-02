<?php

declare(strict_types=1);

namespace Dakulov\BellTest\Model;

class ClassicParticle implements Particle
{
    private readonly Parameter $a;
    private readonly Parameter $b;
    private readonly Parameter $c;

    public function __construct(Spin $a, Spin $b, Spin $c)
    {
        $this->a = new Parameter(Axis::A, $a);
        $this->b = new Parameter(Axis::B, $b);
        $this->c = new Parameter(Axis::C, $c);
    }

    public function getSpin(Axis $axis): Spin
    {
        return match ($axis) {
            Axis::A => $this->a->spin,
            Axis::B => $this->b->spin,
            Axis::C => $this->c->spin,
        };
    }

    public function isSpinDefined(): bool
    {
        return true;
    }
}
