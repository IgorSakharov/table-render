<?php

namespace Vendor\ServiceLoader;

use Src\Kernel;
use Vendor\Request\Request;

/**
 * Class ServiceLoader
 *
 * @package Vendor\ServiceLoader
 */
class ServiceLoader implements ServiceLoaderInterface
{
    /**
     * @var array|mixed
     */
    protected $services = [];

    /**
     * @var Request
     */
    protected $request;

    /**
     * Router constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $filepath       = Kernel::PROJECT_DIR . '/config/services.yml';
        $this->services = yaml_parse_file($filepath);
        $this->request  = $request;

        $this->initializeServices();
    }

    /**
     * @param string $serviceName
     *
     * @return mixed
     * @throws \Exception
     */
    public function getServiceByName(string $serviceName)
    {
        try {
            return $this->services[$serviceName];
        } catch (\Exception $exception) {
            throw new \Exception(sprintf('Service with key %s doesn\'t exist', $serviceName));
        }
    }

    /**
     * @param string $className
     *
     * @return mixed
     * @throws \Exception
     */
    public function getServiceByClassName(string $className)
    {
        try {
            return $this->services[array_search($className, $this->services)];
        } catch (\Exception $exception) {
            throw new \Exception(sprintf('Service %s doesn\'t exist', $className));
        }
    }



    /**
     *  InitializeServices
     */
    protected function initializeServices(): void
    {
        $this->services = array_map(function ($element) {
            return $this->loadService($element['class']);
        }, $this->services);
    }

    /**
     * @param string $className
     *
     * @return string
     * @throws \ReflectionException
     */
    public function loadService(string $className)
    {
        try {
            $methods = new \ReflectionMethod($className, '__construct');
        } catch (\Exception $e) {
            return new $className;
        }

        if ($methods->getParameters() > 0 && !empty($methods->getParameters())) {
            $call_parameters = array_map(function (\ReflectionParameter $item) {
                return [
                    'class'    => $item->getClass()->getNamespaceName() . '\\' . $item->getName(),
                    'position' => $item->getPosition()
                ];
            }, $methods->getParameters());

            return (new \ReflectionClass($className))->newInstance($this->generateParametersForService($call_parameters));
        }

        return new $className;
    }

    /**
     * @param array $call_parameters
     *
     * @return array|null
     * @throws \ReflectionException
     */
    protected function generateParametersForService(array $call_parameters): ?array
    {
        for ($i = 0; $i <= count($call_parameters); $i++) {

            $item = $call_parameters[$i];
            unset($call_parameters[$i]);

            $call_parameters[$item['position']] = $this->loadService($item['class']);
        }

        return $call_parameters;
    }
}