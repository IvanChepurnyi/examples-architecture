<?php
/**
 * Copyright (c) EcomDev B.V., Ivan Chepurnyi
 * See LICENSE file for license details.
 */

namespace Conference\StockExport\Source;


interface Entry
{
    public function getName();

    public function getSku();

    public function getQty();
}
