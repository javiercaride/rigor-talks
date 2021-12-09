<?php

use Codeception\Test\Unit;
use RigorTalks\ColdThresholdSource;
use RigorTalks\Exception\TemperatureNegativeException;
use RigorTalks\Temperature;
use RigorTalks\Test\TemperatureTestClass;

class TemperatureTest extends Unit
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

    public function testSuperHotTemperature()
    {
        $temperature = TemperatureTestClass::take(95);
        $this->assertTrue($temperature->isSuperHot());
    }

    public function testNotSuperHotTemperature()
    {
        $temperature = TemperatureTestClass::take(10);
        $this->assertFalse($temperature->isSuperHot());
    }

    public function testIsSuperColdTemperature()
    {
        $temperature = TemperatureTestClass::take(10);
        $this->assertTrue($temperature->isSuperCold($this->getColdThresholdSource()));
    }

    public function testIsNotSuperColdTemperature()
    {
        $temperature = TemperatureTestClass::take(60);
        $this->assertFalse($temperature->isSuperCold($this->getColdThresholdSource()));
    }

    /**
     * @return ColdThresholdSource
     */
    private function getColdThresholdSource(): ColdThresholdSource
    {
        return new class implements ColdThresholdSource {
            public function getThresholdValue(): int
            {
                return 10;
            }
        };
    }
}