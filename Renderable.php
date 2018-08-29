<?php

interface Renderable
{
    /**
     * Renders element into HTML.
     *
     * @return void
     */
    function render(): void;
}