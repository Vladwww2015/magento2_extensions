<?php

namespace Brander\Page\Block\Adminhtml\Form\Field;

use Brander\Page\Block\Adminhtml\View\Element\Html\Image as ElementImage;

/**
 * Class Image
 * @package Brander\Page\Block\Adminhtml\Form\Field
 */
class Image extends ElementImage
{
    /**
     * Render block HTML
     *
     * @return string
     */
    protected function _toHtml()
    {
        return parent::_toHtml();
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
}