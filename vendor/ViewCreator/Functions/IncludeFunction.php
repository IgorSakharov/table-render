<?php

namespace Vendor\ViewCreator\Functions;

use Vendor\ViewCreator\VariableReplaceTrait;

/**
 * Class IncludeFunction
 * @package Vendor\ViewCreator\Functions
 */
class IncludeFunction
{
    use VariableReplaceTrait;

    /**
     * @var string
     */
    protected $fileContent;

    /**
     * @var array
     */
    protected $parameters;

    /**
     * IncludeFunction constructor.
     * @param string $element
     * @param array $parameters
     */
    public function __construct(string $element, array $parameters)
    {
        $this->fileContent = $this->getFileContent($this->getFunctionArgument($element , 'include'));
        $this->parameters  = $parameters;
    }

    /**
     * @return array
     */
    public function getFileBlocks()
    {
        $result = [];

        foreach ($this->getAllFunctionsByName($this->fileContent , 'block') as $block) {
            $blockName = $this->getFunctionArgument($block, 'block');
            $result[$blockName] = trim($this->getStringBetween($this->fileContent, $blockName . ' %}', '{% endblock %}'));
        }

        return $result;
    }

}