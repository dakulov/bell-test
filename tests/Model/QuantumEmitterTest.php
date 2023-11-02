<?php

declare(strict_types=1);

namespace Tests\Model;

use Dakulov\BellTest\Model\QuantumParticle;
use Dakulov\BellTest\Model\QuantumEmitter;
use Dakulov\BellTest\Model\QuantumProbabilityCalculator;
use Dakulov\BellTest\Model\Randomizer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(QuantumEmitter::class)]
#[CoversClass(QuantumParticle::class)]
class QuantumEmitterTest extends TestCase
{
    public function testCanEmmitEntangledParticles(): void
    {
        $emitter = new QuantumEmitter(
            $this->createMock(Randomizer::class),
            new QuantumProbabilityCalculator()
        );

        $particles = $emitter->emit();
        $this->assertCount(2, $particles);
        $this->assertInstanceOf(QuantumParticle::class, $particles[0]);
        $this->assertInstanceOf(QuantumParticle::class, $particles[1]);
        $this->assertTrue($particles[0]->isEntangledWith($particles[1]));
        $this->assertTrue($particles[1]->isEntangledWith($particles[0]));
    }
}
