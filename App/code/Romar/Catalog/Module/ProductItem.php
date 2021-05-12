<?php

namespace WolfSellers\Catalog\Module;

class ProductItem extends \Magento\Framework\Model\AbstractModel
    implements \WolfSellers\Catalog\Api\Data\ProductItemInterface
{

    /**
     * {@inheritDoc}
     */
    public function setProductName($name)
    {
        return $this->setData(self::PRODUCT_NAME, $name);
    }

    /**
     * {@inheritDoc}
     */
    public function getProductName()
    {
        return $this->getData(self::PRODUCT_NAME);
    }

    /**
     * {@inheritDoc}
     */
    public function setProductCode($code)
    {
        return $this->setData(self::PRODUCT_CODE, $code);
    }

    /**
     * {@inheritDoc}
     */
    public function getProductCode()
    {
        return $this->getData(self::PRODUCT_CODE);
    }

    /**
     * {@inheritDoc}
     */
    public function setPresentation($presentation)
    {
        return $this->setData(self::PRODUCT_PRESENTATION, $presentation);
    }

    /**
     * {@inheritDoc}
     */
    public function getPresentation()
    {
        return $this->getData(self::PRODUCT_PRESENTATION);
    }

    /**
     * {@inheritDoc}
     */
    public function setProductDetails($productDetailsUrl)
    {
        return $this->setData(self::PRODUCT_DETAILS, $productDetailsUrl);
    }

    /**
     * {@inheritDoc}
     */
    public function getProductDetails()
    {
        return $this->getData(self::PRODUCT_DETAILS);
    }

    /**
     * {@inheritDoc}
     */
    public function setAddToCartUrl($addToCartUrl)
    {
        return $this->setData(self::PRODUCT_ADD_TO_CART, $addToCartUrl);
    }

    /**
     * {@inheritDoc}
     */
    public function getAddToCartUrl()
    {
        return $this->getData(self::PRODUCT_ADD_TO_CART);
    }
}
