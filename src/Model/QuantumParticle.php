<?php

declare(strict_types=1);

namespace Dakulov\BellTest\Model;

class QuantumParticle implements Particle
{
    private ?Parameter $parameter = null;

    // For this task we need only two entangled particles
    private ?QuantumParticle $entangledParticle = null;

    public function __construct(
        private readonly Randomizer $randomizer,
        private readonly QuantumProbabilityCalculator $probabilityCalculator
    ) {
    }

    public function entangleWith(QuantumParticle $particle): void
    {
        if ($particle === $this) {
            throw new \RuntimeException('Particle cannot be entangled with itself');
        }

        $this->entangledParticle = $particle;
        $particle->entangledParticle = $this;

        if (!$this->hasConsistentState()) {
            throw InconsistentStateException::create();
        }
    }

    public function isEntangledWith(QuantumParticle $particle): bool
    {
        return $this->entangledParticle === $particle;
    }

    /**
     * @throws \Exception
     */
    public function getSpin(Axis $axis): Spin
    {
        if (!$this->hasConsistentState()) {
            throw InconsistentStateException::create();
        }

        $p = $this->probabilityCalculator->getProbability($this->parameter, $axis);

        $spin = $this->randomizer->getBool($p) ? Spin::UP : Spin::DOWN;

        if ($this->entangledParticle && !$this->entangledParticle->isSpinDefined()) {
            $this->entangledParticle->parameter = new Parameter($axis, $spin->getOpposite());
        }

        $this->parameter = new Parameter($axis, $spin);

        return $spin;
    }

    public function isSpinDefined(): bool
    {
        return $this->parameter !== null;
    }

    public function hasConsistentState(): bool
    {
        if ($this->entangledParticle === null) {
            return true;
        }

        return match ([$this->isSpinDefined(), $this->entangledParticle->isSpinDefined()]) {
            [true, false], [false, true] => false,
            default => true,
        };
    }

    public function setSpinManually(Parameter $parameter): void
    {
        $this->parameter = $parameter;

        if (!$this->hasConsistentState()) {
            throw InconsistentStateException::create();
        }
    }
}
