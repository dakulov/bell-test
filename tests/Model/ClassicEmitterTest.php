<?php

declare(strict_types=1);

namespace Tests\Model;

use Dakulov\BellTest\Model\Axis;
use Dakulov\BellTest\Model\ClassicParticle;
use Dakulov\BellTest\Model\ClassicEmitter;
use Dakulov\BellTest\Model\Parameter;
use Dakulov\BellTest\Model\Randomizer;
use Dakulov\BellTest\Model\Spin;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

#[CoversClass(ClassicEmitter::class)]
#[CoversClass(ClassicParticle::class)]
#[CoversClass(Parameter::class)]
#[CoversClass(Spin::class)]
class ClassicEmitterTest extends TestCase
{
    #[TestWith([[0, 1, 0], Spin::UP, Spin::DOWN, Spin::UP])]
    #[TestWith([[1, 0, 1], Spin::DOWN, Spin::UP, Spin::DOWN])]
    public function testCanEmitParticlesWithOppositeSpines(array $randomValues, Spin $a, Spin $b, Spin $c): void
    {
        $randomizer = $this->createMock(Randomizer::class);
        $randomizer->expects($this->exactly(3))
            ->method('getInt')
            ->with(0, 1)
            ->willReturn(...$randomValues)
        ;

        $emitter = new ClassicEmitter($randomizer);
        $particles = $emitter->emit();

        $this->assertCount(2, $particles);
        $this->assertInstanceOf(ClassicParticle::class, $particles[0]);
        $this->assertInstanceOf(ClassicParticle::class, $particles[1]);
        $this->assertEquals($a, $particles[0]->getSpin(Axis::A));
        $this->assertEquals($a->getOpposite(), $particles[1]->getSpin(Axis::A));
        $this->assertEquals($b, $particles[0]->getSpin(Axis::B));
        $this->assertEquals($b->getOpposite(), $particles[1]->getSpin(Axis::B));
        $this->assertEquals($c, $particles[0]->getSpin(Axis::C));
        $this->assertEquals($c->getOpposite(), $particles[1]->getSpin(Axis::C));
    }
}
