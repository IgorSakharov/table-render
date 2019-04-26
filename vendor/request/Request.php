<?php

namespace Vendor\Request;

class Request implements RequestInterface
{
    const POST = 0,
          GET  = 1;

    /**
     * @var array
     */
    private $data = [];

    /**
     * @var array
     */
    private $server = [];

    /**
     * Request constructor.
     */
    public function __construct()
    {
        $this->data   = $_REQUEST;
        $this->server = $_SERVER;
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function get(string $name)
    {
        if (!empty($this->data[$name])) {
            return $this->data[$name];
        }

        throw new \RuntimeException('This param does not exist in request');
    }

    /**
     * @param $method
     * @return array|null
     */
    public function getAll(int $method = null): ?array
    {
        switch ($method) {
            case self::POST:
                return $_POST ?? null;
            case self::GET:
                return $_GET ?? null;
            default:
                return $this->data;
                break;
        }
    }

    /**
     * @return Request
     */
    public static function createInstance(): Request
    {
        return new self();
    }

    /**
     * @param string $parameter
     * @return mixed
     */
    public function getServerParameter(string $parameter)
    {
        if ($this->server[$parameter]) {
            return $this->server[$parameter];
        }

        throw new \RuntimeException('This param does not exist in server');
    }
}