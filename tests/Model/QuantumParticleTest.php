<?php

declare(strict_types=1);

namespace Tests\Model;

use Dakulov\BellTest\Model\Axis;
use Dakulov\BellTest\Model\InconsistentStateException;
use Dakulov\BellTest\Model\Parameter;
use Dakulov\BellTest\Model\QuantumParticle;
use Dakulov\BellTest\Model\QuantumProbabilityCalculator;
use Dakulov\BellTest\Model\Randomizer;
use Dakulov\BellTest\Model\Spin;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

#[CoversClass(QuantumParticle::class)]
#[CoversClass(Randomizer::class)]
#[CoversClass(QuantumProbabilityCalculator::class)]
#[CoversClass(Parameter::class)]
#[CoversClass(Axis::class)]
#[CoversClass(Spin::class)]
#[CoversClass(InconsistentStateException::class)]
class QuantumParticleTest extends TestCase
{
    #[TestWith([true, Spin::UP])]
    #[TestWith([false, Spin::DOWN])]
    public function testSpinCanBeMeasuredVeryFirstTime(bool $random, Spin $spin): void
    {
        $randomizer = $this->createMock(Randomizer::class);
        $randomizer->expects($this->once())
            ->method('getBool')
            ->with(0.5)
            ->willReturn($random);

        $parameter = new QuantumParticle($randomizer, new QuantumProbabilityCalculator());
        $this->assertEquals($spin, $parameter->getSpin(Axis::A));
    }

    public function testSpinCanBeSetManually(): void
    {
        $particle = new QuantumParticle($this->createMock(Randomizer::class), new QuantumProbabilityCalculator());

        $particle->setSpinManually(new Parameter(Axis::A, Spin::UP));
        $this->assertTrue($particle->isSpinDefined());
    }

    public function testSpinCanNotBeSetIfNewStateIsInconsistent(): void
    {
        $particle1 = new QuantumParticle($this->createMock(Randomizer::class), new QuantumProbabilityCalculator());
        $particle2 = new QuantumParticle($this->createMock(Randomizer::class), new QuantumProbabilityCalculator());

        $particle1->entangleWith($particle2);

        $this->expectException(InconsistentStateException::class);
        $particle1->setSpinManually(new Parameter(Axis::A, Spin::UP));
    }

    #[TestWith([Spin::UP, Axis::A, Axis::A, Spin::UP])]
    #[TestWith([Spin::DOWN, Axis::A, Axis::A, Spin::DOWN])]
    #[TestWith([Spin::UP, Axis::A, Axis::B, Spin::DOWN])]
    #[TestWith([Spin::UP, Axis::A, Axis::C, Spin::UP])]
    #[TestWith([Spin::UP, Axis::B, Axis::C, Spin::UP])]
    #[TestWith([Spin::DOWN, Axis::A, Axis::B, Spin::DOWN])]
    #[TestWith([Spin::DOWN, Axis::A, Axis::C, Spin::UP])]
    #[TestWith([Spin::DOWN, Axis::B, Axis::C, Spin::UP])]
    public function testSpinCanBeMeasuredSecondTime(Spin $currentSpin, Axis $currentAxis, Axis $newAxis, Spin $expectedSpin): void
    {
        $randomizer = $this->createMock(Randomizer::class);
        $randomizer->expects($this->once())
            ->method('getBool')
            ->willReturn($expectedSpin === Spin::UP);

        $parameter = new QuantumParticle($randomizer, new QuantumProbabilityCalculator());
        $parameter->setSpinManually(new Parameter($currentAxis, $currentSpin));

        $this->assertEquals($expectedSpin, $parameter->getSpin($newAxis));
    }

    public function testValueIsDefinedOnlyAfterMeasuring(): void
    {
        $parameter = new QuantumParticle(new Randomizer(), new QuantumProbabilityCalculator());
        $this->assertFalse($parameter->isSpinDefined());
        $parameter->getSpin(Axis::A);
        $this->assertTrue($parameter->isSpinDefined());
    }

    public function testCanBeEntangledWithOtherParticle(): void
    {
        $particle1 = new QuantumParticle($this->createMock(Randomizer::class), new QuantumProbabilityCalculator());
        $particle2 = new QuantumParticle($this->createMock(Randomizer::class), new QuantumProbabilityCalculator());

        $this->assertFalse($particle1->isEntangledWith($particle2));
        $this->assertFalse($particle2->isEntangledWith($particle1));

        $particle1->entangleWith($particle2);

        $this->assertTrue($particle1->isEntangledWith($particle2));
        $this->assertTrue($particle2->isEntangledWith($particle1));
    }

    public function testEntangledParticlesHaveOppositeSpin(): void
    {
        $randomizer = $this->createMock(Randomizer::class);
        $randomizer->expects($this->exactly(2))
            ->method('getBool')
            ->willReturn(true, false);

        $particle1 = new QuantumParticle($randomizer, new QuantumProbabilityCalculator());
        $particle2 = new QuantumParticle($randomizer, new QuantumProbabilityCalculator());

        $particle1->entangleWith($particle2);

        $this->assertEquals($particle1->getSpin(Axis::A), $particle2->getSpin(Axis::A)->getOpposite());
    }
}
