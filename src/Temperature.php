<?php

namespace RigorTalks;

use Doctrine\DBAL\DriverManager;
use RigorTalks\Exception\TemperatureNegativeException;

class Temperature
{
    private int $measure;

    /**
     * @param int $measure
     * @throws TemperatureNegativeException
     */
    private function __construct(int $measure)
    {
        $this->setMeasure($measure);
    }

    public static function take($measure): self
    {
        return new self(($measure));
    }

    public function measure(): int
    {
        return $this->measure;
    }

    public function isSuperHot(): bool
    {
        $connectionParams = array(
            'dbname' => 'mydb',
            'user' => 'user',
            'password' => 'secret',
            'host' => 'localhost',
            'driver' => 'pdo_mysql',
        );

        $connection = DriverManager::getConnection($connectionParams);

    }

    /**
     * @param int $measure
     * @throws TemperatureNegativeException
     */
    private function checkMeasureIsPositive(int $measure): void
    {
        if ($measure <= 0) {
            throw TemperatureNegativeException::fromMeasure($measure);
        }
    }

    /**
     * @param int $measure
     * @throws TemperatureNegativeException
     */
    private function setMeasure(int $measure): void
    {
        $this->checkMeasureIsPositive($measure);
        $this->measure = $measure;
    }
}