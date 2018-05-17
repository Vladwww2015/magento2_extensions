<?php

namespace Brander\Page\Block;

/**
 * Class Continent
 * @package Brander\Page\Block
 */
class Continents extends AbstractBlock implements ContinentsInterface
{
    /**
     * @var array
     */
    protected $_continents = [];

    /**
     * @var null|array
     */
    protected $_currentContinent = null;

    /**
     * @return array
     */
    public function getContinents()
    {
        if(!count($this->_continents)) {
            $this->_continents = $this->_configHelper->getContinents();
        }

        return $this->_continents;
    }

    /**
     * @return bool|mixed
     */
    public function getContinentName()
    {
        $continent = $this->_getCurrentContinent();
        if(is_array($continent) && count($continent)) {
            return $continent['continent_label'];
        }

        return false;
    }

    /**
     * @param $continent
     * @return string
     */
    public function getTargetStorePostData($continent)
    {
        $continent[\Magento\Store\Api\StoreResolverInterface::PARAM_NAME]
            = $continent['store_code'];

        $url = $this->getUrl('brander_page/index/index', $continent);

        return $this->_postDataHelper->getPostData(
            $url,
            $continent
        );
    }

    /**
     * @return array|mixed|null
     */
    protected function _getCurrentContinent()
    {
        if($this->_currentContinent === null) {
            $storeCode = $this->_storeManager->getStore()->getCode();
            foreach ($this->getContinents() as $key => $continent) {
                if($continent['store_code'] === $storeCode){
                    $this->_currentContinent = $continent;
                    break;
                }
            }
        }

        return $this->_currentContinent;
    }
}
