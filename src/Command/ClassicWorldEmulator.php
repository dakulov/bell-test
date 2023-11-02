<?php

declare(strict_types=1);

namespace Dakulov\BellTest\Command;

use Dakulov\BellTest\Model\ClassicEmitter;
use Dakulov\BellTest\Model\Detector;
use Dakulov\BellTest\Model\Experiment;
use Dakulov\BellTest\Model\Randomizer;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'classic-world-emulator',
    description: 'An emulator of the classic world',
)]
class ClassicWorldEmulator extends Command
{
    /**
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Classic World Emulator');

        $experiment = Experiment::createClassic();

        $hints = $experiment->run(10000);

        $io->writeln(sprintf('Result: %s', $hints / 10000));

        return Command::SUCCESS;
    }
}
