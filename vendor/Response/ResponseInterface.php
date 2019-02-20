<?php

namespace Vendor\Response;

interface ResponseInterface
{
    /**
     * Sent response to client
     */
    public function send(): void;
}