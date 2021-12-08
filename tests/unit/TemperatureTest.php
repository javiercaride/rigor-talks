<?php

use RigorTalks\Exception\TemperatureNegativeException;
use RigorTalks\Temperature;

class TemperatureTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    // tests
    public function testTakeRightTemperature()
    {
        $measure = 18;
        $temperature = Temperature::take($measure);
        $this->assertEquals($measure, $temperature->measure());
    }

    public function testTakeNegativeTemperature()
    {
        $this->expectException(TemperatureNegativeException::class);

        $measure = -19;
        $temperature = Temperature::take($measure);
    }

    protected function _before()
    {
    }

    protected function _after()
    {
    }


}