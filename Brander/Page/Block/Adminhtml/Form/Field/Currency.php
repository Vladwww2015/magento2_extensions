<?php

namespace Brander\Page\Block\Adminhtml\Form\Field;

use Magento\Framework\View\Element\Context;
use Magento\Framework\View\Element\Html\Select;

use Brander\Page\Model\Config\Source\Currency as SourceCurrency;

/**
 * Class Stores
 * @package Brander\Page\Block\Adminhtml\Form\Field
 */
class Currency extends Select
{
    /**
     * @var SourceCurrency
     */
    protected $_currency;

    /**
     * Stores constructor.
     * @param Context $context
     * @param SourceStores $stores
     * @param array $data
     */
    public function __construct(
        Context $context,
        SourceCurrency $currency,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->_currency = $currency;
    }

    /**
     * Sets name for input element
     *
     * @param string $value
     * @return $this
     */
    public function setInputName($value)
    {
        return $this->setName($value);
    }

    /**
     * Render block HTML
     *
     * @return string
     */
    protected function _toHtml()
    {
        if (!$this->getOptions()) {
            $this->setOptions($this->_currency->toOptionArray());
        }
        return parent::_toHtml();
    }
}
