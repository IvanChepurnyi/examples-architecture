<?php
/**
 * Copyright (c) EcomDev B.V., Ivan Chepurnyi
 * See LICENSE file for license details.
 */

namespace Conference\StockExport\Command;

use Conference\StockExport\Export;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ExportCommand extends Command
{
    private $export;

    public function __construct(Export $export)
    {
        parent::__construct('conference:stock-export');
        $this->export = $export;
    }

    protected function configure()
    {
        $this->addArgument(
            'store_id',
            InputArgument::REQUIRED,
            'Store id for exporting of data'
        );

        $this->addArgument(
            'output',
            InputArgument::OPTIONAL,
            'Output file path, by default STDOUT',
            'php://stdout'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $scopeId = $input->getArgument('store_id');
        $output = $input->getArgument('output');

        $this->export->export(
            new \SplFileObject($output, 'w'),
            $scopeId
        );
    }


}
