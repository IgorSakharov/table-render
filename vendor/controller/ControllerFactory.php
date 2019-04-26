<?php

namespace Vendor\Controller;

use Vendor\Response\Response;
use Vendor\ServiceLoader\ServiceLoaderInterface;

class ControllerFactory
{
    /**
     * @var ServiceLoaderInterface
     */
    protected $serviceLoader;

    /**
     * ControllerFactory constructor.
     *
     * @param ServiceLoaderInterface $serviceLoader
     */
    public function __construct(ServiceLoaderInterface $serviceLoader)
    {
        $this->serviceLoader = $serviceLoader;
    }

    /**
     * @param string $controller
     * @param string $method
     *
     * @return Response
     * @throws \ReflectionException
     */
    public function callControllerMethod(string $controller, string $method): Response
    {
        $class = $this->loadService($controller, '__construct');

        return $this->callFunction($class, $method);
    }

    /**
     * @param string $className
     * @param string|null $methodName
     *
     * @return object
     * @throws \ReflectionException
     */
    public function loadService(string $className, ?string $methodName = '')
    {
        try {
            $methods = new \ReflectionMethod($className, $methodName);
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

            return (new \ReflectionClass($className))->newInstanceArgs($this->generateParametersForService($call_parameters, $methodName));
        }

        return new $className;
    }

    /**
     * @param $object
     * @param string $methodName
     *
     * @return mixed|string
     * @throws \ReflectionException
     * @throws \Exception
     */
    private function callFunction($object, string $methodName)
    {
        if (!method_exists($object, $methodName)) {
            throw new \Exception(sprintf('Method %s does not exist in class %s', $methodName, get_class($object)));
        }

        try {
            $methods = new \ReflectionMethod(get_class($object), $methodName);
        } catch (\Exception $e) {
            throw new \Exception(sprintf('Method %s does not exist in class %s', $methodName, get_class($object)));
        }

        if ($methods->getParameters() > 0 && !empty($methods->getParameters())) {
            $call_parameters = array_map(function (\ReflectionParameter $item) {
                return [
                    'class' => $item->getClass()->getNamespaceName() . '\\' . $item->getName(),
                    'position' => $item->getPosition()
                ];
            }, $methods->getParameters());

            return (call_user_func_array([$object, $methodName], $this->generateParametersForService($call_parameters, $methodName)));
        }

        return $object->{$methodName} ?? 'Not exist value for this request';
    }

    /**
     * @param array $call_parameters
     * @param string $methodName
     *
     * @return array|null
     * @throws \ReflectionException
     */
    protected function generateParametersForService(array $call_parameters, string $methodName): ?array
    {
        for ($i = 0; $i < count($call_parameters); $i++) {
            $item = $call_parameters[$i];

            if ($item['class']) {
                $call_parameters[$item['position']] = $this->loadService($item['class'], $methodName);
            } else {
                return null;
            }
        }

        return $call_parameters;
    }
}