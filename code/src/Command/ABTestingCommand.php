<?php

namespace App\Command;

use App\Controller\ABTestingController;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:ab-testing',
    description: 'Return designs of given promotion ID using an A/B testing system',
)]
class ABTestingCommand extends Command
{
    public function __construct(private ABTestingController $ABTestingController)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addOption('promoId', '', InputOption::VALUE_REQUIRED, 'Promotion ID', 1)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $responseText = $this->ABTestingController->index($input->getOption('promoId'));

        $output->writeln($responseText);
        return Command::SUCCESS;
    }
}
