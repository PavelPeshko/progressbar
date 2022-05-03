<?php

namespace Peshko\ProgressBar\Block\Cart;

use Magento\Framework\View\Element\Template;

class Sidebar extends Template
{
    /**
     * @var \Peshko\ProgressBar\Helper\Data
     */
    private $helper;

    /**
     * @param Template\Context $context
     * @param \Peshko\ProgressBar\Helper\Data $helper
     * @param array $data
     */
    public function __construct(
        Template\Context               $context,
        \Peshko\ProgressBar\Helper\Data $helper,
        array                          $data = []
    )
    {
        parent::__construct($context, $data);
        $this->helper = $helper;
    }

    /**
     * @return int
     */
    public function getConfigForShippingBar()
    {
        return $this->helper->getPriceForShippingBar();
    }
}
