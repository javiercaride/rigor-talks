<?php

require __DIR__ . '/vendor/autoload.php';

use RigorTalks\Command\TemperatureCommand;
use Symfony\Component\Console\Application;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
$dotenv->required(['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASSWORD', 'DB_PORT']);

$cli = new Application();
$cli->add( new TemperatureCommand);

$cli->run();