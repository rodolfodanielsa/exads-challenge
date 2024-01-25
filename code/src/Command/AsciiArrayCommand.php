<?php

namespace App\Command;

use App\Controller\AsciiArrayController;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:ascii-array',
    description: 'Add a short description for your command',
)]
class AsciiArrayCommand extends Command
{
    public function __construct(private AsciiArrayController $asciiArrayController)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $responseText = $this->asciiArrayController->index();

        // Output the text to the console
        $output->writeln($responseText);

        return Command::SUCCESS;
    }
}
