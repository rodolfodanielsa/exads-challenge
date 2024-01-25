<?php

namespace App\Command;

use App\Controller\PrimeNumberController;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:prime-number',
    description: 'Add a short description for your command',
)]
class PrimeNumberCommand extends Command
{
    public function __construct(private readonly PrimeNumberController $primeNumberController)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('app:example-command')
            ->setDescription('Execute ExampleController and display output in the console');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $responseText = $this->primeNumberController->index();

        // Output the text to the console
        $output->writeln($responseText);

        return Command::SUCCESS;
    }
}
