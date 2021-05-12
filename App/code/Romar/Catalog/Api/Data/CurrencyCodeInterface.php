<?php

namespace WolfSellers\Catalog\Api\Data;

interface CurrencyCodeInterface
{

    /**
     * @param string $currencyCode
     * @return $this
     */
    public function setCurrencyCode($currencyCode);

    /**
     * @return $this
     */
    public function getCurrencyCode();
}
