<?php

namespace Brander\Page\Block;

/**
 * Class SocialLinks
 * @package Brander\Page\Block
 */
class SocialLinks extends AbstractBlock implements SocialLinksInterface
{
    /**
     * @return array
     */
    public function getSocialLinks()
    {
        return $this->_configHelper->getSocialLinks();
    }

    /**
     * @param $path
     * @return string
     */
    public function getSocialUrl($path)
    {
        if(stristr($path, 'http://') || stristr($path, 'https://')) {
            return $path; 
        }
        
        return $this->getUrl($path);
    }

    /**
     * @param $imageName
     * @return string
     */
    public function getImagePath($imageName)
    {
        $image = $this->_getUploadDirPath(self::IMAGES_PATH . $imageName);
        if(!is_dir($image) && file_exists($image)) {
            return $this->_getUploadDirPath(self::IMAGES_PATH . $imageName);
        }

        return false;
    }

    /**
     * @param $uploadDir
     * @return string
     */
    protected function _getUploadDirPath($uploadDir)
    {
        return $this->_mediaDirectory->getRelativePath($uploadDir);
    }
}
