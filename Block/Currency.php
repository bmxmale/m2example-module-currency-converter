<?php

namespace Bmxmale\CurrencyConverter\Block;

use Magento\Framework\View\Element\Template;

/**
 * Class Currency
 *
 * @package Bmxmale\CurrencyConverter\Block
 */
abstract class Currency extends Template
{
    /**
     * @var string
     */
    protected $currencyCode = 'USD';

    /**
     * @var \Magento\Directory\Model\Currency
     */
    protected $baseCurrency;

    /**
     * @var \Magento\Directory\Model\Currency
     */
    protected $currency;

    /**
     * Converter constructor.
     *
     * @param Template\Context $context
     * @param array            $data
     *
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function __construct(
        Template\Context $context,
        array $data = [],
        \Magento\Directory\Model\Currency $currency
    ) {
        parent::__construct($context, $data);

        $this->baseCurrency = $this->_storeManager->getStore()->getBaseCurrency();

        $this->currency = $currency;

    }

    /**
     * Get base currency code
     * @return mixed
     */
    public function getBaseCurrency()
    {
        $baseCurrency = $this->baseCurrency->getCurrencyCode();

        return $baseCurrency;
    }

    /**
     * Get rate for currency
     * @return float
     */
    public function getRateForBaseCurrency()
    {
        $rubRate = (float)$this->baseCurrency->getRate(
            $this->currencyCode
        );

        return $rubRate;
    }

    /**
     * @return string
     */
    public function getCurrencyCode()
    {
        return $this->currencyCode;
    }

    /**
     * @return string
     */
    public function getFormAction()
    {
        return $this->getUrl('currency/converter/convert');
    }
}