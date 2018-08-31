<?php

namespace Brander\SwatchesUrl\Controller;

use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\RouterInterface;

/**
 * Class Router
 * @package Brander\SwatchesUrl\Controller
 */
class Router implements RouterInterface
{

    /**
     * Match application action by request
     *
     * @param RequestInterface $request
     * @return ActionInterface
     */
    public function match(RequestInterface $request)
    {
        $identifier = trim($request->getPathInfo(), '/');
        $request->setPathInfo('433-436-437/brnd-72906/pr23472-kolgoty-zhenskie-conte');
        $identifier = trim($request->getPathInfo(), '/');
    }
}