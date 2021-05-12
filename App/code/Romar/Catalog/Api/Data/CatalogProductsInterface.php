<?php

namespace WolfSellers\Catalog\Api\Data;

interface CatalogProductsInterface
{
    const TOTAL_COUNT = 'total_count';
    const TOTAL_PAGES = 'total_pages';
    const CURRENT_PAGE = 'current_page';
    const NEXT_PAGE = 'next_page';
    const KEY_ITEMS = 'items';

    /**
     * Set total count items
     *
     * @param int $totalCount
     * @return $this
     */
    public function setTotalCount($totalCount);

    /**
     * Returns total count items
     *
     * @return int
     */
    public function getTotalCount();

    /**
     * Set total pages
     *
     * @param int $totalPages
     * @return $this
     */
    public function setTotalPages($totalPages);

    /**
     * Returns total pages
     *
     * @return int
     */
    public function getTotalPages();

    /**
     * Set current page pagination
     *
     * @param int $currentPage
     * @return $this
     */
    public function setCurrentPage($currentPage);

    /**
     * Returns current page pagination
     *
     * @return int
     */
    public function getCurrentPage();

    /**
     * Set next page pagination
     *
     * @param int $nextPage
     * @return $this
     */
    public function setNextPage($nextPage);

    /**
     * Returns next page
     *
     * @return int
     */
    public function getNextPage();

    /**
     * Get product Items
     *
     * @return \WolfSellers\Catalog\Api\Data\ProductItemInterface[]
     */
    public function getItems();

    /**
     * Set product Items
     *
     * @param \WolfSellers\Catalog\Api\Data\ProductItemInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
