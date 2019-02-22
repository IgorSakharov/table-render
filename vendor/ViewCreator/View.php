<?php

namespace Vendor\ViewCreator;

use Vendor\ViewCreator\Functions\ForeachFunction;
use Vendor\ViewCreator\Functions\IncludeBlockFunction;
use Vendor\ViewCreator\Functions\IncludeFunction;
use Vendor\ViewCreator\VariableReplaceTrait;

/**
 * Class View
 * @package Vendor\ViewCreator
 */
class View
{
    use VariableReplaceTrait;

    /**
     * @var array
     */
    protected $parameters;

    /**
     * @var array
     */
    protected $includes = [];

    /**
     * @var array
     */
    protected $blocks = [];

    /**
     * @param string $fileName
     * @param array $parameters
     * @return string
     */
    public function render(string $fileName, array $parameters = null): string
    {
        $this->parameters = $parameters;

        $fileContent = $this->getFileContent($fileName);

        $fileContent = $this->includes($fileContent);

        $fileContent = $this->handelForeach($fileContent);

        $fileContent = $this->removePatterns($fileContent, 'include');

        $fileContent = $this->setVariableValue($fileContent, $this->parameters);

        return $fileContent;

    }

    /**
     * @param string $fileContent
     * @return string|null
     */
    protected function includes(string $fileContent): ?string
    {
        if (preg_match_all('/({% include .*? %})/ms', $fileContent, $elements)) {

            foreach ($elements[0] as $element) {
                $include = new IncludeFunction($element, $this->parameters);
                foreach ($include->getFileBlocks() as $blockName => $blockContent) {
                    $this->blocks[$blockName] = $blockContent;
                }
            }

            return (new IncludeBlockFunction($fileContent, $this->blocks))->replace();
        }

        return $fileContent;
    }

    /**
     * @param string $fileContent
     * @return string
     */
    protected function handelForeach(string $fileContent): string
    {
        $result = '';

        foreach ($this->getAllFunctionsByName($fileContent, 'foreach') as $item) {
            $foreach = new ForeachFunction(
                $fileContent,
                $item,
                $this->parameters
            );

            $result .= $foreach->replace();
        }

        return $result;
    }
}
