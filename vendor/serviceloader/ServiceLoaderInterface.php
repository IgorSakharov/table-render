<?php

namespace Vendor\ServiceLoader;

/**
 * Interface ServiceLoaderInterface
 */
interface ServiceLoaderInterface
{
    /**
     * @param string $serviceName
     *
     * @return mixed
     */
    public function getServiceByName(string $serviceName);

    /**
     * @param string $className
     *
     * @return mixed
     */
    public function getServiceByClassName(string $className);

    /**
     * @param string $className
     *
     * @return mixed
     */
    public function loadService(string $className);
}