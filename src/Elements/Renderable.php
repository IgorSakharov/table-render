<?php

namespace Src\Elements;

/**
 * Interface Renderable
 * @package Src\Elements
 */
interface Renderable
{
    /**
     * Renders element into HTML.
     */
    public function render(): string;
}