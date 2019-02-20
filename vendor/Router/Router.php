<?php

namespace Vendor\Router;

use Src\Kernel;
use Vendor\Request\Request;

class Router
{
    /**
     * @var array|mixed
     */
    private $routs = [];

    /**
     * @var Request
     */
    private $request;

    /**
     * Router constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $filepath      = Kernel::PROJECT_DIR . '/config/route.yml';
        $this->routs   = yaml_parse_file($filepath);
        $this->request = $request;
    }

    /**
     * @return mixed
     */
    public function callController()
    {
        $controller = $this->searchByRoute();
        $class      = new $controller['controller'];

        if (!$class) {
            throw new \RuntimeException(sprintf('%s controller does not exist', $controller['controller']));
        }

        return (call_user_func([$class, $controller['method']], Request::createInstance()))->send();
    }

    /**
     * @return array|null
     */
    private function searchByRoute(): ?array
    {
        $url = parse_url($this->request->getServerParameter('REQUEST_URI'), PHP_URL_PATH);

        foreach ($this->routs as $rout) {
            if ($rout['pattern'] == $url) {
                return $rout;
            }
        }

        throw new \RuntimeException('This route does not exist');
    }

}