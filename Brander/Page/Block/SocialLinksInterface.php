<?php

namespace Brander\Page\Block;

/**
 * Interface SocialLinksInterface
 * @package Brander\Page\Block
 */
interface SocialLinksInterface
{
    const IMAGES_PATH = 'media/brander_page/config/social_links/default/';

    /**
     * @return array
     */
    public function getSocialLinks();

    /**
     * @param $path string
     * @return string
     */
    public function getSocialUrl($path);

    /**
     * @param $imageName string
     * @return string|false
     */
    public function getImagePath($imageName);

}
