<?php

declare(strict_types=1);

namespace Dakulov\BellTest\Model;

class InconsistentStateException extends \LogicException
{
    /**
     * If we define spin for one entangled particle, we define spin for another entangled particle too
     * otherwise we get inconsistent state.
     *
     * There is no reason to use particles in inconsistent state, so it highly likely is just a bug.
     */
    public static function create(): self
    {
        return new self('Inconsistent state');
    }
}
