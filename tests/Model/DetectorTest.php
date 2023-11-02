<?php

declare(strict_types=1);

namespace Tests\Model;

use Dakulov\BellTest\Model\Axis;
use Dakulov\BellTest\Model\Detector;
use Dakulov\BellTest\Model\Particle;
use Dakulov\BellTest\Model\Randomizer;
use Dakulov\BellTest\Model\Spin;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

#[CoversClass(Detector::class)]
class DetectorTest extends TestCase
{
    #[TestWith([0, Axis::A, Spin::UP])]
    #[TestWith([0, Axis::A, Spin::DOWN])]
    #[TestWith([1, Axis::B, Spin::UP])]
    #[TestWith([2, Axis::C, Spin::UP])]
    public function testCanDetectSpin(int $random, Axis $axis, Spin $spin): void
    {
        $randomizer = $this->createMock(Randomizer::class);
        $randomizer->expects($this->once())
            ->method('getInt')
            ->with(0, 2)
            ->willReturn($random);

        $particle = $this->createMock(Particle::class);
        $particle->expects($this->once())
            ->method('getSpin')
            ->with($axis)
            ->willReturn($spin)
        ;

        $detector = new Detector($randomizer);

        $this->assertSame($spin, $detector->measure($particle));
    }
}
