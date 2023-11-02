<?php

declare(strict_types=1);

namespace Dakulov\BellTest\Model;

class QuantumEmitter implements Emitter
{
    public function __construct(
        private readonly Randomizer $randomizer,
        private readonly QuantumProbabilityCalculator $probabilityCalculator
    ) {
    }

    /**
     * @return array<QuantumParticle>
     */
    public function emit(): array
    {
        $result = [];
        $result[] = new QuantumParticle($this->randomizer, $this->probabilityCalculator);
        $result[] = new QuantumParticle($this->randomizer, $this->probabilityCalculator);

        $result[0]->entangleWith($result[1]);

        return $result;
    }
}
