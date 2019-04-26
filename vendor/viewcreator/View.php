<?php

namespace Vendor\ViewCreator;

use Vendor\ViewCreator\Functions\ForeachFunction;
use Vendor\ViewCreator\Functions\IncludeFunction;

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
    public $includes = [];

    /**
     * @var array
     */
    public $blocks = [];

    /**
     * @param string $fileName
     * @param array $parameters
     *
     * @return string
     */
    public function render(string $fileName, array $parameters = null): string
    {
        $this->parameters = $parameters;

        $fileContent = $this->getFileContent($fileName);

        $fileContent = $this->includes($fileContent);

        $this->getBlocks($fileContent);

        $fileContent = $this->replaceBlocks($fileContent);

        $fileContent = $this->handelForeach($fileContent);

        $fileContent = $this->setVariableValue($fileContent, $this->parameters);

        return $fileContent;

    }

    /**
     * @param string $fileContent
     *
     * @return bool|null
     */
    protected function getBlocks(string &$fileContent)
    {
        if ((bool)preg_match_all('/({% block .*? %})/m', $fileContent, $elements)) {
            foreach ($elements[0] as $element) {
                $blockName = $this->getFunctionArgument($element, 'block');
                $this->blocks[$blockName] = $this->getStringBetween(
                    $fileContent,
                    $element,
                    str_replace('block', 'endblock', $element)
                );

                $fileContent = $this->removeStringBetween(
                    $fileContent,
                    $element,
                    str_replace('block', 'endblock', $element)
                );
            }
        } else {
            return $fileContent;
        }

        if ((bool)preg_match_all('/({% block .*? %})/m', $fileContent)) return $this->getBlocks($fileContent);
    }

    protected function replaceBlocks(string $fileContent): string
    {
        if ((bool)preg_match_all('/({% block_include .*? %})/m', $fileContent, $elements)) {
            foreach ($elements[0] as $element) {

                $fileContent = str_replace(
                    $element,
                    $this->blocks[$this->getFunctionArgument($element, 'block_include')],
                    $fileContent
                );
            }
        }
        return $fileContent;
    }

    /**
     * @param string $fileContent
     * @return string|null
     */
    protected function includes(string $fileContent): ?string
    {
        if ((bool)preg_match_all('/({% include .*? %})/m', $fileContent, $elements)) {

            foreach ($elements[0] as $element) {
                $include = new IncludeFunction($element, $this->parameters);
                $fileContent = str_replace($element , $include->getIncludeContent(), $fileContent);
            }
        } else {
            return $fileContent;
        }

        if ( $result = $this->includes($fileContent)) {
            return $result;
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

        if ((bool)preg_match_all('/({% foreach .*? %})/m', $fileContent, $elements)) {
            foreach ($this->getAllFunctionsByName($fileContent, 'foreach') as $item) {
                $foreach = new ForeachFunction(
                    $fileContent,
                    $item,
                    $this->parameters
                );

                $result .= $foreach->replace();
            }
        } else {
            return $fileContent;
        }

        return $result;
    }
}
