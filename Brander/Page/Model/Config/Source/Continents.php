<?php

namespace Brander\Page\Model\Config\Source;

use Magento\Framework\DataObject;
use Magento\Framework\Option\ArrayInterface;

use Brander\Page\Helper\Config;

/**
 * Class Continents
 * @package Brander\Page\Model\Config\Source
 */
class Continents extends DataObject implements ArrayInterface
{
    /**
     * @var Config
     */
    protected $_configHelper;

    /**
     * Continents constructor.
     * @param Config $configHelper
     */
    public function __construct(
        Config $configHelper
    ) {
        $this->_configHelper = $configHelper;
    }

    /**
     * @return array
     */
    public function toOptionArray()
    {
        $options = [];

        $continents = $this->_configHelper->getContinents();

        foreach($continents as $key  => $value)
        {
            $options[] = ['value' => $key, 'label' => $value['continent_label']];
        }

        return $options;
    }
}
