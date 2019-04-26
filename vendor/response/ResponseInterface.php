<?php

namespace Vendor\Response;

interface ResponseInterface
{
    /**
     * @return string
     */
    public function send(): string;
}