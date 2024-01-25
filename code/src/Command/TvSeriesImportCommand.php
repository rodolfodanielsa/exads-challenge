<?php

namespace App\Command;

use App\Constants\TvSeriesConstants;
use App\Controller\TvSeriesController;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:tvseries:import',
    description: 'Add a short description for your command',
)]
class TvSeriesImportCommand extends Command
{
    public function __construct(private readonly TvSeriesController $tvSeriesController)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('app:tv_series:import')
            ->setDescription('Execute ExampleController and display output in the console');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $responseText = $this->tvSeriesController->import(TvSeriesConstants::TV_SERIES_DATA);

        // Output the text to the console
        $output->writeln($responseText);

        return Command::SUCCESS;
    }
}
