<?php

namespace Brander\Page\Block\Adminhtml\System\Config\Form\Field;

/**
 * Class SocialLinks
 * @package Brander\Page\Block\Adminhtml\System\Config\Form\Field
 */
class SocialLinks extends MultitableAbstract
{
    /**
     * prepare to renderer
     */
    public function _prepareToRender()
    {
        $this->addColumn('label', [
            'label' => __('Label'),
            'style' => 'width:120px',
        ]);

        $this->addColumn('image', [
            'label' => __('Image'),
            'renderer' => $this->getLayout()->createBlock(
                \Brander\Page\Block\Adminhtml\Form\Field\Image::class,
                '',
                ['data' => [
                    'element'                  => $this->getElement(),
                    'is_render_to_js_template' => true
                ]]
            )
        ]);
        $this->addColumn('url',   [
            'label' => __('Url'),
            'style' => 'width:120px',
        ]);
        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add');
    }
}
