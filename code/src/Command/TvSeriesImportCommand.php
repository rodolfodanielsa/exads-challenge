<?php

namespace App\Command;

use App\Constants\TvSeriesConstants;
use App\Controller\TvSeriesController;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:tvseries:import',
    description: 'Import data to DB related to TV Series',
)]
class TvSeriesImportCommand extends Command
{
    public function __construct(private readonly TvSeriesController $tvSeriesController)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $responseText = $this->tvSeriesController->import(TvSeriesConstants::TV_SERIES_DATA);

        $output->writeln($responseText);

        return Command::SUCCESS;
    }
}
