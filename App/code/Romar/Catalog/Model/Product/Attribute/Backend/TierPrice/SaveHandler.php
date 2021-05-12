<?php

namespace WolfSellers\Catalog\Model\Product\Attribute\Backend\TierPrice;

class SaveHandler extends \Magento\Catalog\Model\Product\Attribute\Backend\TierPrice\SaveHandler
{
    protected function prepareTierPrice(array $data): array
    {

        $useForAllGroups = (int)$data['cust_group'] === $this->groupManagement->getAllCustomersGroup()->getId();
        $customerGroupId = $useForAllGroups ? 0 : $data['cust_group'];
        $tierPrice = array_merge(
            $this->getAdditionalFields($data),
            [
                'website_id' => $data['website_id'],
                'all_groups' => (int)$useForAllGroups,
                'customer_group_id' => $customerGroupId,
                'value' => $data['price'] ?? null,
                'qty' => $this->parseQty($data['price_qty']),
                'currency_code' => $data['currency_code']
            ]
        );

        return $tierPrice;
    }
}
