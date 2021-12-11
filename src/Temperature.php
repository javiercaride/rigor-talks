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

    public static function take($measure): static
    {
        return new static($measure);
    }

    public static function fromSensor(Sensor $sensor): static
    {
        return new static($sensor->thermometer()->measure()->value());
    }

    public function measure(): int
    {
        return $this->measure;
    }

    public function isSuperHot(): bool
    {
        $hotThreshold = $this->getHotThreshold();
        return $this->measure() >= $hotThreshold;
    }

    public function isSuperCold(ColdThresholdSource $thresholdSource): bool
    {
        return $this->measure() <= $thresholdSource->getThresholdValue();
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

    /**
     * @return int
     * @throws \Doctrine\DBAL\Exception
     */
    protected function getHotThreshold(): int
    {
        $connectionParams = array(
            'dbname' => $_ENV['DB_NAME'],
            'user' => $_ENV['DB_USER'],
            'password' => $_ENV['DB_PASSWORD'],
            'host' => $_ENV['DB_HOST'],
            'driver' => $_ENV['DB_DRIVER'],
            'driverOptions' => array(
                \PDO::ATTR_EMULATE_PREPARES => FALSE
            )
        );

        $connection = DriverManager::getConnection($connectionParams);

        $result = $connection->executeQuery("SELECT super_hot FROM temperature_threshold");
        return $result->fetchOne();
    }
}