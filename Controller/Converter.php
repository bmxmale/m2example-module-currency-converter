<?php

namespace Bmxmale\CurrencyConverter\Controller;


use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Index
 *
 * @package Bmxmale\CurrencyConverter\Controller\Converter
 */
abstract class Converter extends Action
{
    /**
     * @var PageFactory
     */
    protected $pageFactory;

    /**
     * Converter constructor.
     *
     * @param Context     $context
     * @param PageFactory $pageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $pageFactory
    ) {
        $this->pageFactory = $pageFactory;

        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $pageFactory = $this->pageFactory->create();
        $pageFactory->getConfig()->getTitle()->prepend('Currency Converter');

        return $pageFactory;
    }
}