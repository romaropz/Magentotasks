<?php

namespace WolfSellers\Catalog\Plugin;

class Price
{
    const TIER_PRICES = 1;
    const PRODUCT = 0;

    public function __construct()
    {
    }

    public function aroundSetTierPrices(
        \Magento\Catalog\Model\Product\Type\Price $subject,
        callable $proceed,
        ...$args
    )
    {
        $result = $proceed(...$args);

        /**
         *argument product
         */
        $product = $args[self::PRODUCT];
        $tierPricesData = $product->getData('tier_price');
        /**
         *argument tierPrices
         */
        $tierPrices = $args[self::TIER_PRICES];
        foreach ($tierPrices as $key => $price) {
            $extensionAttributes = $price->getExtensionAttributes();

            $tierPricesData[$key]['currency_code'] = $extensionAttributes ? $extensionAttributes->getCurrencyCode() : '';
        }

        $product->setData('tier_price', $tierPricesData);
        return $result;
    }
}
