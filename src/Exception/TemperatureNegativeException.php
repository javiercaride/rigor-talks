<?php

namespace RigorTalks\Exception;

use Throwable;

class TemperatureNegativeException extends \Exception
{
    private function __construct($message = "Measure should be positive", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public static function fromMeasure(int $measure)
    {
        return new self("Measure should be positive. Passed value: {$measure}");
    }
}