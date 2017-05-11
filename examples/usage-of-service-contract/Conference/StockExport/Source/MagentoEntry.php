<?php
/**
 * Copyright (c) EcomDev B.V., Ivan Chepurnyi
 * See LICENSE file for license details.
 */

namespace Conference\StockExport\Source;


use Magento\Catalog\Api\Data\ProductInterface;
use Magento\CatalogInventory\Api\Data\StockStatusInterface;

class MagentoEntry implements Entry
{
    private $product;
    private $stockStatus;

    public function __construct(ProductInterface $product, StockStatusInterface $stockStatus)
    {
        $this->product = $product;
        $this->stockStatus = $stockStatus;
    }


    public function getName()
    {
        return $this->product->getName();
    }

    public function getSku()
    {
        return $this->product->getSku();
    }

    public function getQty()
    {
        return $this->stockStatus->getQty();
    }
}
