<?php
declare(strict_types=1);

namespace VTweb\Shopping\Infrastructure\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use VTweb\Shopping\Application\Write\Product\ImportProducts\ImportProducts;

#[AsCommand(name: 'vtweb:shopping:import-products')]
class ImportProductsCommand extends Command
{
    public function __construct(
        private readonly MessageBusInterface $bus,
    ) {
        parent::__construct(null);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->bus->dispatch(new ImportProducts());

        return self::SUCCESS;
    }
}
