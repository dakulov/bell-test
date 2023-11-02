<?php

declare(strict_types=1);

namespace Dakulov\BellTest\Model;

class QuantumProbabilityCalculator
{
    public function getProbability(?Parameter $previous, Axis $newAxis): float
    {
        return match ($previous) {
            null => 0.5,
            default => cos(deg2rad($this->getAngleBetweenSpinAndNewAxis($previous, $newAxis)) / 2) ** 2
        };
    }

    public function getAngleBetweenSpinAndNewAxis(Parameter $previous, Axis $newAxis): float
    {
        $angle = match ($previous->spin) {
            Spin::UP => abs($previous->axis->getAngle() - $newAxis->getAngle()),
            Spin::DOWN => abs($previous->axis->getAngle() - $newAxis->getAngle() + 180.0),
        };

        while ($angle > 360.0) {
            $angle -= 360.0;
        }

        return $angle > 180.0 ? 360.0 - $angle : $angle;
    }
}
