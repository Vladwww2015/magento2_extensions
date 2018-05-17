<?php

namespace Brander\Page\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class Index
 * @package Brander\Page\Controller\Index
 */
class Index extends Action
{
    /**
     * @var StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * Index constructor.
     * @param Context $context
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        Context $context,
        StoreManagerInterface $storeManager
    )
    {
        parent::__construct($context);
        $this->_storeManager = $storeManager;
    }

    /**
     * Execute action based on request and return result
     *
     * Note: Request will be added as operation argument in future
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        $currency = (string)$this->getRequest()->getParam('currency');
        if ($currency) {
            $this->_storeManager->getStore()->setCurrentCurrencyCode($currency);
        }
        
        $storeUrl = $this->_storeManager->getStore()->getBaseUrl();
        $this->getResponse()->setRedirect($this->_redirect->getRedirectUrl($storeUrl));
    }
}
