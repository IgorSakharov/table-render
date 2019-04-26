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
     * @return string|null
     */
    public function getIncludeContent(): ?string
    {
        return $this->fileContent;
    }

    /**
     * @return array|null
     */
    public function getFileBlocks(): ?array
    {
        $result    = [];
        $functions = $this->getAllFunctionsByName($this->fileContent , 'block_include');

        if ($functions) {
            foreach ($functions as $block) {
                $blockName = $this->getFunctionArgument($block, 'block_include');
                $result[$blockName] = trim($this->getStringBetween($this->fileContent, $blockName . ' %}', '{% endblock %}'));
                $this->fileContent = $this->removePatterns($this->fileContent, 'block');
                $this->fileContent = $this->removePatterns($this->fileContent, 'endblock', false);
            }
        } else {
            return null;
        }

        return $result;
    }

}