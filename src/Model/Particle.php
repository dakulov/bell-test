<?php

declare(strict_types=1);

namespace Dakulov\BellTest\Model;

interface Particle
{
    public function getSpin(Axis $axis): Spin;

    public function isSpinDefined(): bool;
}
