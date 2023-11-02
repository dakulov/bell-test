<?php

declare(strict_types=1);

namespace Tests\Model;

use Dakulov\BellTest\Model\ClassicEmitter;
use Dakulov\BellTest\Model\Detector;
use Dakulov\BellTest\Model\Emitter;
use Dakulov\BellTest\Model\Experiment;
use Dakulov\BellTest\Model\Particle;
use Dakulov\BellTest\Model\QuantumEmitter;
use Dakulov\BellTest\Model\Spin;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Experiment::class)]
#[CoversClass(ClassicEmitter::class)]
#[CoversClass(QuantumEmitter::class)]
#[CoversClass(Detector::class)]
class ExperimentTest extends TestCase
{
    public function testCanBeRun(): void
    {
        $pAlice1 = $this->createMock(Particle::class);
        $pAlice2 = $this->createMock(Particle::class);
        $pAlice3 = $this->createMock(Particle::class);
        $pBob1 = $this->createMock(Particle::class);
        $pBob2 = $this->createMock(Particle::class);
        $pBob3 = $this->createMock(Particle::class);

        $emitter = $this->createMock(Emitter::class);
        $emitter->expects($this->exactly(3))
            ->method('emit')
            ->willReturn([$pAlice1, $pBob1], [$pAlice2, $pBob2], [$pAlice3, $pBob3]);

        $alice = $this->createMock(Detector::class);
        $alice->expects($this->exactly(3))
            ->method('measure')
            ->willReturnCallback(function (Particle $p) use ($pAlice1, $pAlice2, $pAlice3) {
                static $i = 0;
                match (++$i) {
                    1 => $this->assertSame($pAlice1, $p),
                    2 => $this->assertSame($pAlice2, $p),
                    3 => $this->assertSame($pAlice3, $p),
                };

                return match ($i) {
                    1, 3 => Spin::UP,
                    2 => Spin::DOWN,
                };
            });

        $bob = $this->createMock(Detector::class);
        $bob->expects($this->exactly(3))
            ->method('measure')
            ->willReturnCallback(function (Particle $p) use ($pBob1, $pBob2, $pBob3) {
                static $i = 0;
                match (++$i) {
                    1 => $this->assertSame($pBob1, $p),
                    2 => $this->assertSame($pBob2, $p),
                    3 => $this->assertSame($pBob3, $p),
                };

                return match ($i) {
                    1, 2 => Spin::UP,
                    3 => Spin::DOWN,
                };
            });

        $experiment = new Experiment($emitter, $alice, $bob);
        $this->assertSame(1, $experiment->run(3));
    }

    public function testCanCreateClassicExperiment(): void
    {
        $experiment = Experiment::createClassic();
        $this->assertInstanceOf(Experiment::class, $experiment);
    }

    public function testCanCreateQuantumExperiment(): void
    {
        $experiment = Experiment::createQuantum();
        $this->assertInstanceOf(Experiment::class, $experiment);
    }
}
