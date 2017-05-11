<?php
/**
 * Copyright (c) EcomDev B.V., Ivan Chepurnyi
 * See LICENSE file for license details.
 */

namespace Conference\StockExport\Source;


use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\CatalogInventory\Api\StockRegistryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Store\Model\StoreManagerInterface;

class MagentoEntryGateway implements EntryGateway
{
    private $searchCriteriaBuilder;

    private $stockRegistry;

    private $productRepository;

    private $storeManager;

    private $pageSize;

    private $magentoEntryFactory;

    public function __construct(
        SearchCriteriaBuilder $searchCriteriaBuilder,
        ProductRepositoryInterface $productRepository,
        StoreManagerInterface $storeManager,
        MagentoEntryFactory $magentoEntryFactory,
        StockRegistryInterface $stockRegistry
    ) {
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->productRepository = $productRepository;
        $this->storeManager = $storeManager;
        $this->pageSize = 1000;
        $this->magentoEntryFactory = $magentoEntryFactory;
        $this->stockRegistry = $stockRegistry;
    }

    public function getTotalPages($scopeId): int
    {
        $this->storeManager->setCurrentStore($scopeId);
        $searchCriteria = $this->createProductSearchCriteria(1, 1);
        $searchResult = $this->productRepository->getList($searchCriteria);

        return ceil($searchResult->getTotalCount() / $this->pageSize);
    }

    public function getEntriesByPage($scopeId, $page): \Traversable
    {
        $this->storeManager->setCurrentStore($scopeId);

        $searchCriteria = $this->createProductSearchCriteria($this->pageSize, $page);
        $searchResult = $this->productRepository->getList($searchCriteria);

        foreach ($searchResult->getItems() as $productItem) {
            yield $this->magentoEntryFactory->create([
                'product' => $productItem,
                'stockStatus' => $this->stockRegistry->getStockStatus(
                    $productItem->getId(),
                    $scopeId
                ),
            ]);
        }
    }

    private function createProductSearchCriteria($pageSize, $currentPage): \Magento\Framework\Api\SearchCriteria
    {
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('type_id', 'simple')
            ->addFilter('status', '1')
            ->setPageSize($pageSize)
            ->setCurrentPage($currentPage)
            ->create()
        ;
        return $searchCriteria;
    }
}
