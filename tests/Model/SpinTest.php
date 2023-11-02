<?php

declare(strict_types=1);

namespace Tests\Model;

use Dakulov\BellTest\Model\Spin;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Spin::class)]
class SpinTest extends TestCase
{
    public function testCanGetOpposite(): void
    {
        $this->assertEquals(Spin::UP, Spin::DOWN->getOpposite());
        $this->assertEquals(Spin::DOWN, Spin::UP->getOpposite());
    }
}
