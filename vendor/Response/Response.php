<?php

namespace Vendor\Response;


class Response implements ResponseInterface
{
    /**
     * @var array
     */
    private $headers = [];

    /**
     * @var string
     */
    private $content = '';

    /**
     * @var int
     */
    private $codeStatus = 200;

    /**
     * Response constructor.
     * @param string $content
     * @param int $code
     */
    public function __construct(string $content, int $code = 200)
    {
        $this->content = $content;
        $this->codeStatus = $code;
    }

    /**
     * @param string $name
     * @param string $value
     * @return Response
     */
    public function addHeader(string $name, string $value): self
    {
        $this->headers[] = [
            $name,
            $value
        ];

        return $this;
    }

    /**
     * Send response to client
     */
    public function send(): void
    {
        echo $this->content;
    }

    /**
     * @param int $code
     * @return Response
     */
    public function setCodeStatus($code = 200): self
    {
        http_response_code($code);

        return $this;
    }
}