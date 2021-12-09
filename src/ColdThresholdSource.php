<?php

namespace RigorTalks;

interface ColdThresholdSource
{
    /**
     * Returns the threshold value for the low temperature
     * @return int temperature in celsius degrees
     */
    public function getThresholdValue(): int;
}