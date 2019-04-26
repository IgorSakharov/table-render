<?php

namespace Src;

use Vendor\Controller\ControllerFactory;
use Vendor\Router\Router;
use Vendor\Request\Request;
use Vendor\ServiceLoader\ServiceLoader;

/**
 * Class Kernel
 * @package Src
 */
class Kernel
{
    const PROJECT_DIR = __DIR__ . '/..';

    /**
     * @var Router
     */
    private $router;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var ServiceLoader
     */
    private $serviceLoader;

    /**
     * Kernel constructor.
     */
    public function __construct()
    {
        $this->request = Request::createInstance();
    }

    /**
     * do all need functions for set up project
     */
    public function handel()
    {
        $this->router        = new Router($this->request);
        $this->serviceLoader = new ServiceLoader($this->request);
    }

    /**
     * call controller from routs
     */
    public function send()
    {
        echo (new ControllerFactory($this->serviceLoader))
                ->callControllerMethod(
                    $this->router->getControllerClass(),
                    $this->router->getControllerMethod()
            )->send();
    }
}