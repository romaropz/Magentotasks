<?php

namespace WolfSellers\Catalog\Api;

interface CatalogProductsByCategoryInterface
{
    /**
     * @param string $categoryId
     * @param string $currentPage
     * @return \WolfSellers\Catalog\Api\Data\CatalogProductsInterface
     */
    public function getList($categoryId, $currentPage);
}
