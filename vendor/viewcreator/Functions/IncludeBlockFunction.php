<?php

namespace Vendor\ViewCreator\Functions;

use Vendor\ViewCreator\VariableReplaceTrait;

/**
 * Class IncludeBlockFunction
 * @package Vendor\ViewCreator\Functions
 */
class IncludeBlockFunction
{
    use VariableReplaceTrait;

    /**
     * @var string
     */
    protected $content;

    /**
     * @var array
     */
    protected $blocks;

    /**
     * IncludeBlockFunction constructor.
     * @param string $content
     * @param array $blocks
     */
    public function __construct(string $content, array $blocks)
    {
        $this->content = $content;
        $this->blocks  = $blocks;
    }

    /**
     * @return mixed|string
     */
    public function replace()
    {
        foreach ($this->getAllFunctionsByName($this->content, 'block_include') as $item) {
            $blockName = $this->getFunctionArgument($item, 'block_include');

            $this->content = str_replace('{% block_include '. $blockName .' %}', $this->blocks[$blockName], $this->content);
        }

        return $this->content;
    }
}