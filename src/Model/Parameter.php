<?php

declare(strict_types=1);

namespace Dakulov\BellTest\Model;

class Parameter
{
    public function __construct(
        public readonly Axis $axis,
        public readonly Spin $spin
    ) {
    }
}
