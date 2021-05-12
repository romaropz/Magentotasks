<?php

namespace WolfSellers\Catalog\Api\Data;

interface ProductItemInterface
{
    const PRODUCT_NAME = "name";
    const PRODUCT_CODE = "code";
    const PRODUCT_PRESENTATION = "presentation";
    const PRODUCT_DETAILS = "productDetails";
    const PRODUCT_ADD_TO_CART = "addToCart";

    /**
     * Set product name
     *
     * @param string $name
     * @return $this
     */
    public function setProductName($name);

    /**
     * get product name
     *
     * @return string
     */
    public function getProductName();

    /**
     * Set product code
     *
     * @param string $code
     * @return $this
     */
    public function setProductCode($code);

    /**
     * get product code
     *
     * @return string
     */
    public function getProductCode();

    /**
     * Set product presentation
     *
     * @param string $presentation
     * @return $this
     */
    public function setPresentation($presentation);

    /**
     * get product presentation
     *
     * @return string
     */
    public function getPresentation();

    /**
     * Set product details url
     *
     * @param string $productDetailsUrl
     * @return $this
     */
    public function setProductDetails($productDetailsUrl);

    /**
     * get product details url
     *
     * @return string
     */
    public function getProductDetails();

    /**
     * Set add to cart url
     *
     * @param string $addToCartUrl
     * @return $this
     */
    public function setAddToCartUrl($addToCartUrl);

    /**
     * get add to cart url
     *
     * @return string
     */
    public function getAddToCartUrl();
}
