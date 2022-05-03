<?php

namespace Peshko\ProgressBar\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

class Data extends AbstractHelper
{
    const PRICE_SHIPPING_BAR = 'shippingbar/shippingsection/shipping_bar';

    /**
     * @return int
     */
    public function getPriceForShippingBar()
    {
        return $this->scopeConfig->getValue(self::PRICE_SHIPPING_BAR, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
}
