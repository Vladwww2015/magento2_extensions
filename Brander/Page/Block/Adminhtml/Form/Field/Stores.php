<?php

namespace Brander\Page\Block\Adminhtml\Form\Field;

use Magento\Framework\View\Element\Context;
use Magento\Framework\View\Element\Html\Select;

use Brander\Page\Model\Config\Source\Stores as SourceStores;

/**
 * Class Stores
 * @package Brander\Page\Block\Adminhtml\Form\Field
 */
class Stores extends Select
{
    /**
     * @var SourceStores
     */
    protected $_stores;

    /**
     * Stores constructor.
     * @param Context $context
     * @param SourceStores $stores
     * @param array $data
     */
    public function __construct(
        Context $context,
        SourceStores $stores,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->_stores = $stores;
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
            $this->setOptions($this->_stores->toOptionArray());
        }
        return parent::_toHtml();
    }
}
