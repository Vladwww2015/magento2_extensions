<?php

namespace Brander\Page\Block\Adminhtml\System\Config\Form\Field;

use Magento\Framework\DataObject;
use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;

/**
 * Class Continents
 * @package Brander\Page\Block\Adminhtml\System\Config\Form\Field
 */
class Continents extends AbstractFieldArray
{
    /**
     * @var string
     */
    protected $_storeCode;

    /**
     * @var string
     */
    protected $_currency;

    /**
     * prepare to render
     */
    public function _prepareToRender()
    {
        $this->addColumn('continent_label', [
            'label' => __('Continent Label'),
            'style' => 'width:120px',
        ]);

        $this->addColumn('store_code', [
            'label' => __('Store'),
            'style' => 'width:120px',
            'renderer' => $this->getStoreCodeRenderer()
        ]);

        $this->addColumn('currency',   [
            'label' => __('Currency'),
            'style' => 'width:120px',
            'renderer' => $this->getCurrencyRenderer()
        ]);

        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add');
    }

    /**
     * Returns renderer for country element
     *
     * @return Countries
     */
    protected function getStoreCodeRenderer()
    {
        if (!$this->_storeCode) {
            $this->_storeCode = $this->getLayout()->createBlock(
                \Brander\Page\Block\Adminhtml\Form\Field\Stores::class,
                '',
                ['data' => ['is_render_to_js_template' => true]]
            );
        }
        return $this->_storeCode;
    }

    /**
     * Returns renderer for country element
     *
     * @return Countries
     */
    protected function getCurrencyRenderer()
    {
        if (!$this->_currency) {
            $this->_currency = $this->getLayout()->createBlock(
                \Brander\Page\Block\Adminhtml\Form\Field\Currency::class,
                '',
                ['data' => ['is_render_to_js_template' => true]]
            );
        }
        return $this->_currency;
    }

    /**
     * Prepare existing row data object
     *
     * @param DataObject $row
     * @return void
     */
    protected function _prepareArrayRow(DataObject $row)
    {
        $storeCode = $row->getStoreCode();
        $options = [];
        if ($storeCode) {
            $options['option_' . $this->getStoreCodeRenderer()->calcOptionHash($storeCode)]
                = 'selected="selected"';

            $currency = $row->getCurrency();
            $options['option_' . $this->getCurrencyRenderer()->calcOptionHash($currency)]
                    = 'selected="selected"';
        }
        $row->setData('option_extra_attrs', $options);
    }
}
