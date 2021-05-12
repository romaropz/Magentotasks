<?php

namespace WolfSellers\Catalog\Module;

use \Magento\Framework\Api\FilterBuilder;
use \Magento\Framework\Api\SearchCriteriaBuilder;
use \Magento\Catalog\Api\ProductRepositoryInterface;
use \Magento\Catalog\Block\Product\ListProduct;
use \WolfSellers\Catalog\Api\Data\CatalogProductsInterface;
use \WolfSellers\Catalog\Api\Data\ProductItemInterfaceFactory;

class CatalogProductsByCategory implements \WolfSellers\Catalog\Api\CatalogProductsByCategoryInterface
{
    const ATTRIBUTE_CATEGORY_ID = "category_id";
    const FILTER_CONDITION_TYPE_EQ = "eq";
    const EMPTY_ITEMS = 0;
    const MAX_ITEMS_PER_PAGE = 10;

    /**
     * @var FilterBuilder
     */
    protected $_filterBuilder;

    /**
     * @var SearchCriteriaBuilder
     */
    protected $_searchCriteriaBuilder;

    /**
     * @var ProductRepositoryInterface
     */
    protected $_productRepository;

    /**
     * @var ListProduct
     */
    protected $_listProduct;

    /**
     * @var CatalogProductsInterface
     */
    protected $_catalogProducts;

    /**
     * @var ProductItemInterfaceFactory
     */
    protected $_productItemInterfaceFactory;

    /**
     * CatalogProductsByCategory constructor.
     * @param FilterBuilder $filterBuilder
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param ProductRepositoryInterface $productRepository
     * @param ListProduct $listProduct
     * @param CatalogProductsInterface $catalogProducts
     * @param ProductItemInterfaceFactory $productItemInterfaceFactory
     */
    public function __construct(
        FilterBuilder $filterBuilder,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        ProductRepositoryInterface $productRepository,
        ListProduct $listProduct,
        CatalogProductsInterface $catalogProducts,
        ProductItemInterfaceFactory $productItemInterfaceFactory
    )
    {
        $this->_filterBuilder = $filterBuilder;
        $this->_searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->_productRepository = $productRepository;
        $this->_listProduct = $listProduct;
        $this->_catalogProducts = $catalogProducts;
        $this->_productItemInterfaceFactory = $productItemInterfaceFactory;
    }

    /**
     * {@inheritDoc}
     */
    public function getList($categoryId, $currentPage = 1)
    {
        $filter = $this->_filterBuilder
            ->setField(self::ATTRIBUTE_CATEGORY_ID)
            ->setConditionType(self::FILTER_CONDITION_TYPE_EQ)
            ->setValue($categoryId)
            ->create();

        $this->_searchCriteriaBuilder->addFilters([$filter]);
        $this->_searchCriteriaBuilder->setPageSize(self::MAX_ITEMS_PER_PAGE)->setCurrentPage($currentPage);

        $searchCriteria = $this->_searchCriteriaBuilder->create();
        $result = $this->_productRepository->getList($searchCriteria);
        $itemsResult = [];
        if ($result->getTotalCount() > self::EMPTY_ITEMS) {
            foreach ($result->getItems() as $itemProduct) {
                $productItem = $this->_productItemInterfaceFactory->create();
                $productItem->setProductName($itemProduct->getName());
                $productItem->setProductCode($itemProduct->getSku());
                $productItem->setPresentation($itemProduct->getSku());
                $productItem->setProductDetails($itemProduct->getProductUrl());
                $productItem->setAddToCartUrl($this->_listProduct->getAddToCartUrl($itemProduct));

                $itemsResult[] = $productItem;
            }
        }

        $totalPages = ceil($result->getTotalCount() / self::MAX_ITEMS_PER_PAGE);
        if ($currentPage < $totalPages) {
            $nextPage = ++$currentPage;
        } else {
            $nextPage = $totalPages;
        }

        $this->_catalogProducts->setTotalCount($result->getTotalCount());
        $this->_catalogProducts->setTotalPages($totalPages);
        $this->_catalogProducts->setCurrentPage($currentPage);
        $this->_catalogProducts->setNextPage($nextPage);
        $this->_catalogProducts->setItems($itemsResult);

        return $this->_catalogProducts;
    }
}
