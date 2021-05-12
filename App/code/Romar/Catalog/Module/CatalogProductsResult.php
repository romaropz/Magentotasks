<?php

namespace WolfSellers\Catalog\Module;

use WolfSellers\Catalog\Api\Data\CatalogProductsInterface;

class CatalogProductsResult extends \Magento\Framework\Model\AbstractModel
    implements \WolfSellers\Catalog\Api\Data\CatalogProductsInterface
{
    /**
     * {@inheritDoc}
     */
    public function setTotalCount($totalCount)
    {
        return $this->setData(self::TOTAL_COUNT, $totalCount);
    }

    /**
     * {@inheritDoc}
     */
    public function getTotalCount()
    {
        return $this->getData(self::TOTAL_COUNT);
    }

    /**
     * {@inheritDoc}
     */
    public function setCurrentPage($currentPage)
    {
        return $this->setData(self::CURRENT_PAGE, $currentPage);
    }

    /**
     * {@inheritDoc}
     */
    public function getCurrentPage()
    {
        return $this->getData(self::CURRENT_PAGE);
    }

    /**
     * {@inheritDoc}
     */
    public function setNextPage($nextPage)
    {
        return $this->setData(self::NEXT_PAGE, $nextPage);
    }

    /**
     * {@inheritDoc}
     */
    public function getNextPage()
    {
        return $this->getData(self::NEXT_PAGE);
    }

    /**
     * {@inheritDoc}
     */
    public function getItems()
    {
        return $this->getData(self::KEY_ITEMS);
    }

    /**
     * {@inheritDoc}
     */
    public function setItems(array $items)
    {
        return $this->setData(self::KEY_ITEMS, $items);
    }

    /**
     * {@inheritDoc}
     */
    public function setTotalPages($totalPages)
    {
        return $this->setData(self::TOTAL_PAGES, $totalPages);
    }

    /**
     * {@inheritDoc}
     */
    public function getTotalPages()
    {
        return $this->getData(self::TOTAL_PAGES);
    }
}
