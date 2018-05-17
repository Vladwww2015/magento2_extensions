<?php

namespace Brander\Page\Model\Config\Source;

use Magento\Framework\DataObject;
use Magento\Store\Model\StoreRepository;
use Magento\Framework\Option\ArrayInterface;

/**
 * Class Stores
 * @package Brander\Page\Model\Config\Source
 */
class Stores extends DataObject implements ArrayInterface
{
    /**
     * @var Rate
     */
    protected $_storeRepository;

    /**
     * @param StoreRepository      $storeRepository
     */
    public function __construct(
        StoreRepository $storeRepository
    ) {
        $this->_storeRepository = $storeRepository;
    }

    /**
     * @return array
     */
    public function toOptionArray()
    {
        $stores = $this->_storeRepository->getList();
        $storeList = array();
        foreach ($stores as $store) {
            if($store->getId() != 0) {
                $storeList[] = ['value' => $store->getCode(), 'label' => $store->getName()];
            }
        }

        return $storeList;
    }
}
