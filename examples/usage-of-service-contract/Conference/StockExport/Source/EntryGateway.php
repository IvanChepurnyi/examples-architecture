<?php
/**
 * Copyright (c) EcomDev B.V., Ivan Chepurnyi
 * See LICENSE file for license details.
 */

namespace Conference\StockExport\Source;

interface EntryGateway
{
    public function getTotalPages($scopeId): int;

    /**
     * @return Entry[]|\Traversable
     */
    public function getEntriesByPage($scopeId, $page): \Traversable;
}
