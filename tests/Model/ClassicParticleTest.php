<?php

declare(strict_types=1);

namespace Tests\Model;

use Dakulov\BellTest\Model\Axis;
use Dakulov\BellTest\Model\ClassicParticle;
use Dakulov\BellTest\Model\Parameter;
use Dakulov\BellTest\Model\Spin;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ClassicParticle::class)]
#[CoversClass(Parameter::class)]
class ClassicParticleTest extends TestCase
{
    public function testCanBeMeasured(): void
    {
        $parameter = new ClassicParticle(Spin::UP, Spin::DOWN, Spin::UP);
        $this->assertEquals(Spin::UP, $parameter->getSpin(Axis::A));
        $this->assertEquals(Spin::DOWN, $parameter->getSpin(Axis::B));
        $this->assertEquals(Spin::UP, $parameter->getSpin(Axis::C));
    }

    public function testValueIsAlwaysDefined(): void
    {
        $parameter = new ClassicParticle(Spin::UP, Spin::DOWN, Spin::UP);
        $this->assertTrue($parameter->isSpinDefined());
    }
}
