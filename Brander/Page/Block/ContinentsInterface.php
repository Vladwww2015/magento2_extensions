<?php

namespace Brander\Page\Block;

/**
 * Interface ContinentsInterface
 * @package Brander\Page\Block
 */
interface ContinentsInterface
{
    /**
     * @return []
     */
    public function getContinents();

    /**
     * @return null|string
     */
    public function getContinentName();

}