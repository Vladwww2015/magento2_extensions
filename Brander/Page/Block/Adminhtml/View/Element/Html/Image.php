<?php


namespace Brander\Page\Block\Adminhtml\View\Element\Html;

use Magento\Framework\Data\Form;
use Magento\Framework\Filesystem;
use Magento\Framework\View\Element\Context;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Data\Form\Element\Image as ElementImage;

/**
 * Class Image
 * @package Brander\Page\Block\Adminhtml\View\Element\Html
 */
class Image extends UploaderAbstract
{
    /**
     * @var ElementImage
     */
    protected $_image;

    /**
     * @var Form
     */
    protected $_form;

    /**
     * @var Filesystem\Directory\WriteInterface
     */
    protected $_mediaDirectory;

    /**
     * Image constructor.
     * @param Context $context
     * @param ElementImage $image
     * @param Filesystem $filesystem
     * @param array $data
     */
    public function __construct(
        Form $form,
        Context $context,
        ElementImage $image,
        Filesystem $filesystem,
        array $data = []
    )
    {
        $this->_form           = $form;
        $this->_image          = $image;
        $this->_mediaDirectory = $filesystem->getDirectoryWrite(DirectoryList::MEDIA);
        parent::__construct($context, $data);
    }

    /**
     * @return string
     */
    public function prepareHtml()
    {
        $value = $this->getElement()->getValue();

        if(count($value)) {
            $image = $this->_mediaDirectory->getRelativePath('brander_page/config/social_links/default/<%- image %>');
            $this->_image->setValue($image);
        }

        $this->_image->setName($this->getName());
        $this->_image->setForm($this->_form);
        $html = $this->_image->getElementHtml();
        $html = str_replace('\'', '\\\'', $html);

        return $html;
    }
}
