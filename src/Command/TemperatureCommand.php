<?php
namespace RigorTalks\Command;

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
            $temperature = Temperature::take(rand(-5, 100));
            $output->writeln("The measured temperature is {$temperature->measure()}");
        } catch (TemperatureNegativeException $ex) {
            $output->writeln("The temperature is negative");
        }
        return Command::SUCCESS;
    }
}