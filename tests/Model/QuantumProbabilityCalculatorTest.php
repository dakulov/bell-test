<?php

declare(strict_types=1);

namespace Tests\Model;

use Dakulov\BellTest\Model\Axis;
use Dakulov\BellTest\Model\Parameter;
use Dakulov\BellTest\Model\QuantumProbabilityCalculator;
use Dakulov\BellTest\Model\Spin;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

#[CoversClass(QuantumProbabilityCalculator::class)]
#[CoversClass(Axis::class)]
#[CoversClass(Parameter::class)]
class QuantumProbabilityCalculatorTest extends TestCase
{
    #[TestWith([Spin::UP, Axis::A, Axis::A, 0])]
    #[TestWith([Spin::UP, Axis::B, Axis::B, 0])]
    #[TestWith([Spin::UP, Axis::C, Axis::C, 0])]
    #[TestWith([Spin::DOWN, Axis::A, Axis::A, 180])]
    #[TestWith([Spin::DOWN, Axis::B, Axis::B, 180])]
    #[TestWith([Spin::DOWN, Axis::C, Axis::C, 180])]
    #[TestWith([Spin::UP, Axis::A, Axis::B, 120])]
    #[TestWith([Spin::UP, Axis::A, Axis::C, 120])]
    #[TestWith([Spin::UP, Axis::B, Axis::A, 120])]
    #[TestWith([Spin::UP, Axis::B, Axis::C, 120])]
    #[TestWith([Spin::UP, Axis::C, Axis::A, 120])]
    #[TestWith([Spin::UP, Axis::C, Axis::B, 120])]
    #[TestWith([Spin::DOWN, Axis::A, Axis::B, 60])]
    #[TestWith([Spin::DOWN, Axis::A, Axis::C, 60])]
    #[TestWith([Spin::DOWN, Axis::B, Axis::A, 60])]
    #[TestWith([Spin::DOWN, Axis::B, Axis::C, 60])]
    #[TestWith([Spin::DOWN, Axis::C, Axis::A, 60])]
    #[TestWith([Spin::DOWN, Axis::C, Axis::B, 60])]
    public function testCanReturnAngleBetweenSpinAndNewAxis(Spin $spin, Axis $axis, Axis $newAxis, $expected): void
    {
        $calculator = new QuantumProbabilityCalculator();

        $parameter = new Parameter($axis, $spin);
        $this->assertEquals($expected, $calculator->getAngleBetweenSpinAndNewAxis($parameter, $newAxis));
    }

    #[TestWith([null, Axis::A, 0.5])]
    #[TestWith([null, Axis::B, 0.5])]
    #[TestWith([null, Axis::C, 0.5])]
    #[TestWith([new Parameter(Axis::A, Spin::UP), Axis::A, 1.0])]
    #[TestWith([new Parameter(Axis::A, Spin::DOWN), Axis::A, 0.0])]
    #[TestWith([new Parameter(Axis::A, Spin::UP), Axis::B, 0.25])]
    #[TestWith([new Parameter(Axis::A, Spin::UP), Axis::C, 0.25])]
    #[TestWith([new Parameter(Axis::A, Spin::DOWN), Axis::A, 0.0])]
    #[TestWith([new Parameter(Axis::A, Spin::DOWN), Axis::B, 0.75])]
    #[TestWith([new Parameter(Axis::A, Spin::DOWN), Axis::C, 0.75])]
    #[TestWith([new Parameter(Axis::B, Spin::UP), Axis::A, 0.25])]
    #[TestWith([new Parameter(Axis::B, Spin::UP), Axis::C, 0.25])]
    public function testCanCalculateProbability(?Parameter $previous, Axis $newAxis, float $expected): void
    {
        $calculator = new QuantumProbabilityCalculator();

        $this->assertEqualsWithDelta(
            $expected,
            $calculator->getProbability($previous, $newAxis),
            0.0001
        );
    }
}
