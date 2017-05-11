<?php
/**
 * Copyright (c) EcomDev B.V., Ivan Chepurnyi
 * See LICENSE file for license details.
 */

namespace Conference\StockExport;

use Conference\StockExport\Source\EntryGateway;

class Export
{
    private $entryGateway;

    public function __construct(EntryGateway $entryGateway)
    {
        $this->entryGateway = $entryGateway;
    }

    public function export(\SplFileObject $file, $scopeId)
    {
        $file->fputcsv(['name', 'sku', 'qty']);

        $totalPages = $this->entryGateway->getTotalPages($scopeId);

        for ($page = 1; $page <= $totalPages; $page ++) {
            foreach ($this->entryGateway->getEntriesByPage($scopeId, $page) as $entry) {
                $file->fputcsv([$entry->getName(), $entry->getSku(), $entry->getQty()]);
            }
        }
    }
}
