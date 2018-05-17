<?php

namespace Brander\Page\Block\Adminhtml\View\Element\Html;

use Magento\Framework\View\Element\AbstractBlock;

/**
 * Class UploaderAbstract
 * @package Brander\Page\Block\Adminhtml\View\Element\Html
 */
abstract class UploaderAbstract extends AbstractBlock
{

    /**
     * @return string
     */
    abstract public function prepareHtml();

    /**
     * Alias for toHtml()
     *
     * @return string
     */
    public function getHtml()
    {
        return $this->toHtml();
    }

    /**
     * Calculate CRC32 hash for option value
     *
     * @param string $optionValue Value of the option
     * @return string
     */
    public function calcOptionHash($optionValue)
    {
        return sprintf('%u', crc32($this->getName() . $this->getId() . $optionValue));
    }

    /**
     * Render HTML
     *
     * @return string
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    protected function _toHtml()
    {
        return $this->prepareHtml();
    }
}
