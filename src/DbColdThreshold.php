<?php

namespace RigorTalks;

use Doctrine\DBAL\DriverManager;

class DbColdThreshold implements ColdThresholdSource
{
    /**
     * @inheritDoc
     */
    public function getThresholdValue(): int
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

        $result = $connection->executeQuery("SELECT super_cold FROM temperature_threshold");
        return $result->fetchOne();
    }
}