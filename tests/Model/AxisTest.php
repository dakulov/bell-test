<?php

declare(strict_types=1);

namespace Tests\Model;

use Dakulov\BellTest\Model\Axis;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Axis::class)]
class AxisTest extends TestCase
{
    public function testCanReturnAngle(): void
    {
        $this->assertEquals(0.0, Axis::A->getAngle());
        $this->assertEquals(120.0, Axis::B->getAngle());
        $this->assertEquals(240.0, Axis::C->getAngle());
    }
}
