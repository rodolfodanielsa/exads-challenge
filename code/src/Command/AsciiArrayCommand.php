<?php

namespace App\Command;

use App\Controller\AsciiArrayController;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:ascii-array',
    description: 'Remove random char from array and return removed char',
)]
class AsciiArrayCommand extends Command
{
    public function __construct(private readonly AsciiArrayController $asciiArrayController)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $responseText = $this->asciiArrayController->index();

        $output->writeln($responseText);

        return Command::SUCCESS;
    }
}
