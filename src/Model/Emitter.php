<?php

declare(strict_types=1);

namespace Dakulov\BellTest\Model;

interface Emitter
{
    /**
     * @return array<Particle>
     */
    public function emit(): array;
}
