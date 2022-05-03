<?php

namespace Peshko\ProgressBar\Model\Carrier;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Quote\Model\Quote\Address\RateRequest;
use Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory;
use Magento\Quote\Model\Quote\Address\RateResult\MethodFactory;
use Magento\Shipping\Model\Carrier\AbstractCarrier;
use Magento\Shipping\Model\Carrier\CarrierInterface;
use Magento\Shipping\Model\Rate\ResultFactory;
use Magento\Checkout\Model\Session as CheckoutSession;

class FreeShipping extends AbstractCarrier implements CarrierInterface
{
    /**
     * @var string
     */
    protected $_code = 'custom_free_shipping';

    /**
     * @var bool
     */
    protected $_isFixed = true;


    /**
     * @var CheckoutSession
     */
    protected $_checkoutSession;

    /**
     * @var ResultFactory
     */
    private $rateResultFactory;

    /**
     * @var MethodFactory
     */
    private $rateMethodFactory;


    /**
     * @param ScopeConfigInterface $scopeConfig
     * @param ErrorFactory $rateErrorFactory
     * @param \Psr\Log\LoggerInterface $logger
     * @param ResultFactory $rateResultFactory
     * @param MethodFactory $rateMethodFactory
     * @param CheckoutSession $_checkoutSession
     * @param array $data
     */
    public function __construct(
        ScopeConfigInterface     $scopeConfig,
        ErrorFactory             $rateErrorFactory,
        \Psr\Log\LoggerInterface $logger,
        ResultFactory            $rateResultFactory,
        MethodFactory            $rateMethodFactory,
        CheckoutSession          $_checkoutSession,
        array                    $data = []
    )
    {
        parent::__construct($scopeConfig, $rateErrorFactory, $logger, $data);

        $this->_checkoutSession = $_checkoutSession;
        $this->rateResultFactory = $rateResultFactory;
        $this->rateMethodFactory = $rateMethodFactory;
    }

    /**
     * @param RateRequest $request
     * @return \Magento\Shipping\Model\Rate\Result|bool
     */
    public function collectRates(RateRequest $request)
    {
        if (!$this->getConfigFlag('active') || !$this->validateSubtotal()) {
            return false;
        }

        /** @var \Magento\Shipping\Model\Rate\Result $result */
        $result = $this->rateResultFactory->create();

        /** @var \Magento\Quote\Model\Quote\Address\RateResult\Method $method */
        $method = $this->rateMethodFactory->create();

        $method->setCarrier($this->_code);
        $method->setCarrierTitle($this->getConfigData('title'));

        $method->setMethod($this->_code);
        $method->setMethodTitle($this->getConfigData('name'));

        $shippingCost = (float)$this->getConfigData('shipping_cost');

        $method->setPrice($shippingCost);
        $method->setCost($shippingCost);

        $result->append($method);

        return $result;
    }

    /**
     * @return array
     */
    public function getAllowedMethods()
    {
        return [$this->_code => $this->getConfigData('name')];
    }

    /**
     * @return bool
     */
    protected function validateSubtotal()
    {
        $subtotalThreshold = (float)$this->getConfigData('goal');
        $subtotal = $this->getSubtotal();

        if (!$subtotalThreshold || !$subtotal) {
            return false;
        }

        if ($subtotalThreshold > $subtotal) {
            return false;
        }

        return true;
    }

    /**
     * @return false|float
     */
    protected function getSubtotal()
    {
        try {
            return $this->_checkoutSession->getQuote()->getSubtotal();
        } catch (NoSuchEntityException $e) {
            $this->_logger->critical($e);
        } catch (LocalizedException $e) {
            $this->_logger->critical($e);
        }
        return false;
    }
}
