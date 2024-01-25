<?php

namespace App\Command;

use App\Controller\PrimeNumberController;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:prime-number',
    description: 'Return list of number from 1 to 100 with info if number is prime or have multiples',
)]
class PrimeNumberCommand extends Command
{
    public function __construct(private readonly PrimeNumberController $primeNumberController)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $responseText = $this->primeNumberController->index();

        $output->writeln($responseText);

        return Command::SUCCESS;
    }
}
