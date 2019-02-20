<?php

namespace Vendor\Request;

interface RequestInterface
{
    /**
     * @param string $name
     * @return mixed
     */
    public function get(string $name);

    /**
     * @param $method
     * @return array|null
     */
    public function getAll(int $method = null): ?array;
}