<?php

namespace Bmxmale\CurrencyConverter\Controller\Converter;

use Bmxmale\CurrencyConverter\Controller\Converter;
use Magento\Directory\Model\Currency;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\View\Result\PageFactory;
use Magento\Store\Model\StoreManager;

/**
 * Class Convert
 *
 * @package Bmxmale\CurrencyConverter\Controller\Converter
 */
class Convert extends Converter
{
    const CURRENCY_CODE_TO_CONVERT = 'RUB';

    /**
     * @var JsonFactory
     */
    protected $jsonFactory;

    /**
     * @var StoreManager
     */
    protected $storeManager;

    /**
     * @var Currency
     */
    protected $baseCurrency;

    /**
     * Convert constructor.
     *
     * @param Context      $context
     * @param PageFactory  $pageFactory
     * @param JsonFactory  $jsonFactory
     * @param StoreManager $storeManager
     *
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        JsonFactory $jsonFactory,
        StoreManager $storeManager
    ) {
        parent::__construct($context, $pageFactory);

        $this->jsonFactory = $jsonFactory;
        $this->storeManager = $storeManager;
        $this->baseCurrency = $storeManager->getStore()->getBaseCurrency();
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Json|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Page
     */
    public function execute()
    {

        $amount = (float)$this->getRequest()->getParam('amount', 0);

        if ($amount <= 0) {
            $result = [
                'status'  => false,
                'message' => __('Wrong amount')
            ];
            return $this->createJsonResponse($result);
        }

        $ratePLNtoRUB = (float)$this->baseCurrency->getRate(
            self::CURRENCY_CODE_TO_CONVERT
        );
        $convertedAmount = $this->convertRUBtoPLN($amount, $ratePLNtoRUB);

        $result = [
            'status' => true,
            'rate'   => $ratePLNtoRUB,
            'result' => $convertedAmount
        ];
        return $this->createJsonResponse($result);
    }

    /**
     * @param array $response
     *
     * @return \Magento\Framework\Controller\Result\Json
     */
    protected function createJsonResponse(array $response)
    {
        return $this->jsonFactory->create()->setData($response);
    }

    /**
     * Convert amount from RUB to PLN currency
     *
     * @param $amount
     * @param $rate
     *
     * @return bool|float
     */
    protected function convertRUBtoPLN($amount, $rate)
    {
        if ($rate <= 0 || $amount <= 0) {
            return false;
        }

        return round($amount * $rate, 2);
    }
}