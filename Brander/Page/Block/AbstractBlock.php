<?php

namespace Brander\Page\Block;

use Magento\Framework\Filesystem;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\Data\Helper\PostHelper;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\View\Element\Template\Context;

use Brander\Page\Helper\Config;

/**
 * Class AbstractBlock
 * @package Brander\Page\Block
 */
abstract class AbstractBlock extends Template
{
    /**
     * @var UrlInterface
     */
    protected $_url;

    /**
     * @var Config
     */
    protected $_configHelper;

    /**
     * @var PostHelper
     */
    protected $_postDataHelper;

    /**
     * @var Filesystem\Directory\WriteInterface
     */
    protected $_mediaDirectory;

    /**
     * AbstractBlock constructor.
     * @param Context $context
     * @param Config $configHelper
     * @param PostHelper $postDataHelper
     * @param Filesystem $filesystem
     * @param UrlInterface $url
     * @param array $data
     */
    public function __construct(
        Context $context,
        Config $configHelper,
        PostHelper $postDataHelper,
        Filesystem $filesystem,
        UrlInterface $url,
        array $data = []
    )
    {
        $this->_url            = $url;
        $this->_configHelper   = $configHelper;
        $this->_postDataHelper = $postDataHelper;
        $this->_mediaDirectory = $filesystem->getDirectoryWrite(DirectoryList::MEDIA);
        parent::__construct($context, $data);
    }

    /**
     * @return string
     */
    public function toHtml()
    {
        if ($this->_configHelper->isModuleEnabled()) {
            return parent::toHtml();
        }
    }
}
