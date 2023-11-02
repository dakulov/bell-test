<?php

declare(strict_types=1);

namespace Dakulov\BellTest\Model;

class Experiment
{
    public function __construct(
        private readonly Emitter $emitter,
        private readonly Detector $alice,
        private readonly Detector $bob
    ) {
    }

    public static function createClassic(): self
    {
        return new self(
            new ClassicEmitter(new Randomizer()),
            new Detector(new Randomizer()),
            new Detector(new Randomizer()),
        );
    }

    public static function createQuantum(): self
    {
        return new self(
            new QuantumEmitter(new Randomizer(), new QuantumProbabilityCalculator()),
            new Detector(new Randomizer()),
            new Detector(new Randomizer()),
        );
    }

    /**
     * Returns the number of times the spins of the particles were equal.
     * @throws \Exception
     */
    public function run(int $count): int
    {
        $equalCount = 0;
        for ($i = 0; $i < $count; $i++) {
            $particles = $this->emitter->emit();

            $aliceSpin = $this->alice->measure($particles[0]);
            $bobSpin = $this->bob->measure($particles[1]);

            $equalCount += $aliceSpin === $bobSpin ? 1 : 0;
        }

        return $equalCount;
    }
}
