<?php

require __DIR__ . '/vendor/autoload.php';

use RigorTalks\Command\TemperatureCommand;
use Symfony\Component\Console\Application;

$cli = new Application();
$cli->add( new TemperatureCommand);

$cli->run();