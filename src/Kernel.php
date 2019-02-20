<?php

namespace Src;

use Vendor\Router\Router;
use Vendor\Request\Request;

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
        $this->router = new Router($this->request);
    }

    /**
     * call controller from routs
     */
    public function send()
    {
        echo $this->router->callController();
    }
}