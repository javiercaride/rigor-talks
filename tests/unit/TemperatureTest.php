<?php

use Codeception\Test\Unit;
use RigorTalks\ColdThresholdSource;
use RigorTalks\Exception\TemperatureNegativeException;
use RigorTalks\Temperature;
use RigorTalks\Sensor;
use RigorTalks\Thermometer;
use RigorTalks\Measure;
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

    public function testTakeZeroTemperature()
    {
        $this->expectException(TemperatureNegativeException::class);

        $measure = 0;
        $temperature = Temperature::take($measure);
    }

    public function testTakeNegativeTemperature()
    {
        $this->expectException(TemperatureNegativeException::class);

        $measure = -1;
        $temperature = Temperature::take($measure);
    }

    public function testSuperHotTemperature()
    {
        $temperature = TemperatureTestClass::take(80);
        $this->assertTrue($temperature->isSuperHot());
    }

    public function testNotSuperHotTemperature()
    {
        $temperature = TemperatureTestClass::take(50);
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

    public function testTakeTemperatureFromSensor()
    {
        $temperature = Temperature::fromSensor($this->getSensor());
        $this->assertEquals(50, $temperature->measure());
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

    private function getSensor(): Sensor
    {
        return new class implements Sensor, Thermometer, Measure {
            public function sensor(): Sensor
            {
                return $this;
            }

            public function thermometer(): Thermometer
            {
                return $this;
            }

            public function measure(): Measure
            {
                return $this;
            }

            public function value(): int
            {
                return 50;
            }
        };
    }
}