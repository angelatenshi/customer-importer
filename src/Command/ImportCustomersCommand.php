<?php

namespace App\Command;

use App\Service\Importer\CustomerImporterInterface;
use App\Service\CustomerService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:import-customers')]
class ImportCustomersCommand extends Command
{
    public function __construct(
        private CustomerImporterInterface $importer,
        private CustomerService $customerService
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Imports Australian customers from randomuser.me');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $customers = $this->importer->fetchCustomers();
        $output->writeln('Importing ' . count($customers) . ' customers...');

        foreach ($customers as $item) {
            $this->customerService->saveOrUpdate($item);
        }

        $output->writeln('<info>✅ Import completed.</info>');
        return Command::SUCCESS;
    }
}
