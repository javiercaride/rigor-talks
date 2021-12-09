<?php
namespace RigorTalks\Test;

use RigorTalks\Temperature;

class TemperatureTestClass extends Temperature
{
    protected function getHotThreshold(): int
    {
        return 80;
    }
}