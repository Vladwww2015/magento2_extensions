<?php

namespace Brander\Page\Helper;

use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\Serialize\SerializerInterface;

/**
 * Class Config
 * @package Brander\Page\Helper
 */
class Config extends AbstractHelper
{
    const CONTINENTS        = 'page/header/continents';

    const MODULE_ENABLE     = 'page/general/enable';

    const SOCIAL_LINKS      = 'page/footer/social_links';

    const DEFAULT_CONTINENT = 'page/header/default_continent';

    /**
     * @var SerializerInterface
     */
    protected $_serializer;

    /**
     * Config constructor.
     * @param Context $context
     * @param SerializerInterface $serializer
     */
    public function __construct(
        Context $context,
        SerializerInterface $serializer
    )
    {
        parent::__construct($context);
        $this->_serializer = $serializer;
    }

    /**
     * @param $path
     * @param $store
     * @return mixed
     */
    public function getConfig($path, $store)
    {
        return $this->scopeConfig->getValue($path, $store);
    }

    /**
     * @return mixed
     */
    public function isModuleEnabled()
    {
        return $this->getConfig(static::MODULE_ENABLE, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return array|bool|float|int|null|string
     */
    public function getContinents()
    {
        $continents = $this->getConfig(static::CONTINENTS,ScopeInterface::SCOPE_STORE);
        if($continents) {
            return $this->_serializer->unserialize($continents);
        }
        return [];
    }

    /**
     * @return mixed
     */
    public function getDefaultContinent()
    {
        return $this->getConfig(static::DEFAULT_CONTINENT,ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return array|bool|float|int|null|string
     */
    public function getSocialLinks()
    {
        $socialLinks = $this->getConfig(static::SOCIAL_LINKS, ScopeInterface::SCOPE_STORE);
        if($socialLinks) {
            return $this->_serializer->unserialize($socialLinks);
        }

        return [];
    }
}
