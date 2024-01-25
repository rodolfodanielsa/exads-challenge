<?php

namespace App\Command;

use App\Controller\TvSeriesController;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:tvseries:next',
    description: 'Add a short description for your command',
)]
class TvSeriesNextCommand extends Command
{
    public function __construct(private readonly TvSeriesController $tvSeriesController)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addOption('date', 'd', InputOption::VALUE_REQUIRED, 'Date')
            ->addOption('title', 't', InputOption::VALUE_REQUIRED, 'Title')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $title = $date = null;
        if ($input->getOption('date')) {
            $inputDate = $input->getOption('date');
            $date = new \DateTime($inputDate);
        }
        if ($input->getOption('title')) {
            $title = $input->getOption('title');
        }
        $response = $this->tvSeriesController->index($date, $title);

        $output->writeln($response);

        return Command::SUCCESS;
    }
}
