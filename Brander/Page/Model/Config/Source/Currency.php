<?php

namespace Brander\Page\Model\Config\Source;

use Magento\Framework\App\Helper\Context;
use Magento\Framework\Data\OptionSourceInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

/**
 * Class Currency
 * @package Brander\Page\Model\Config\Source
 */
class Currency implements OptionSourceInterface
{
    /**
     * @var \Magento\Framework\App\Helper\Context
     */
    protected $context;

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @param \Magento\Framework\App\Helper\Context $context
     */
    public function __construct(Context $context)
    {
        $this->context = $context;
        $this->scopeConfig = $context->getScopeConfig();
    }

    /**
     * Get allowed currencies
     *
     * @return  array of allowed Currencies
     *
     **/
    public function getAllowedCurrencies()
    {
        $allowedCurrencies = $this->scopeConfig->getValue('currency/options/allow');
        $allowedCurrencies = explode(',', $allowedCurrencies);

        $options = [];
        foreach($allowedCurrencies as $key  => $value)
        {
            $options[] = ['value' => $value, 'label' => $value];
        }

        return $options;
    }


    /**
     * Admin Config action
     *
     * @return array
     */
    public function toOptionArray()
    {
        return $this->getAllowedCurrencies();
    }
}