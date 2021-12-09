<?php
namespace RigorTalks\Command;

use RigorTalks\DbColdThreshold;
use RigorTalks\Exception\TemperatureNegativeException;
use RigorTalks\Temperature;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TemperatureCommand extends Command
{
    protected static $defaultName = 'app:take-temperature';

    protected function configure(): void
    {
        $this->setHelp("Returns a temperature measure");
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $temperature = Temperature::take(rand(-10, 100));
            $output->writeln("The measured temperature is {$temperature->measure()}");

            if ($temperature->isSuperHot()) {
                $output->writeln("Be careful! The temperature is too high!");
            }

            if ($temperature->isSuperCold(new DbColdThreshold())) {
                $output->writeln("Be careful! The temperature is too low!");
            }

        } catch (TemperatureNegativeException $ex) {
            $output->writeln("The temperature is negative");
        }
        return Command::SUCCESS;
    }
}