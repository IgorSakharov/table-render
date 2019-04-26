<?php

namespace Vendor\ViewCreator;

use Src\Kernel;

/**
 * Trait VariableReplaceTrait
 * @package Vendor\ViewCreator
 */
trait VariableReplaceTrait {

    /**
     * @param string $fileContent
     * @param array $parameters
     * @return string
     */
    protected function setVariableValue(string $fileContent, array $parameters): string
    {
        if (!$parameters) {
            return $fileContent;
        }

        foreach ($parameters as $name => $value) {
            $fileContent = str_replace('{{ ' . $name . ' }}', $value, $fileContent);
        }

        return $fileContent;
    }

    /**
     * @param string $content
     * @param string $start
     * @param string $end
     * @return bool|string
     */
    protected function getStringBetween(string $content, string $start, string $end): string
    {
        $string = ' ' . $content;
        $ini    = strpos($string, $start);
        if ($ini == 0) {
            return '';
        }

        $ini += strlen($start);
        $len  = strpos($string, $end, $ini) - $ini;

        return trim(substr($string, $ini, $len));
    }

    /**
     * @param string $fileContent
     * @param string $functionName
     * @param bool $anotherText
     * @return string
     */
    protected function removePatterns(string $fileContent, string $functionName, $anotherText = true): string
    {
        $param = $anotherText ? ' .*?' : '';
        $fileContent = preg_replace('/({% ' . $functionName . $param . ' %})/m', '', $fileContent);

        return trim($fileContent);
    }

    /**
     * @param string $fileContent
     * @param string $content
     * @param string $start
     * @param string $end
     * @return string
     */
    protected function replaceString(string $fileContent, string $content, string $start, string $end): string
    {
        return str_replace($start . PHP_EOL . $this->getStringBetween($fileContent, $start, $end) . PHP_EOL . $end, $content, $fileContent);
    }

    protected function replaceStringBetween(string $string, string $start, string $end, string $content = ''): string
    {
        $beginningPos = strpos($string, $start);
        $endPos = strpos($string, $end);
        if (!$beginningPos || !$endPos) {
            return $string;
        }

        $textToDelete = substr($string, $beginningPos, ($endPos + strlen($end)) - $beginningPos);

        return trim(str_replace($textToDelete, $content, $string));
    }

    protected function removeStringBetween(string $string, string $start, string $end): string
    {
        $beginningPos = strpos($string, $start);
        $endPos = strpos($string, $end);
        if (!$beginningPos || !$endPos) {
            return $string;
        }

        $textToDelete = substr($string, $beginningPos, ($endPos + strlen($end)) - $beginningPos);

        return trim(str_replace($textToDelete, '', $string));
    }

    /**
     * @param string $fileName
     * @return string
     */
    protected function getFilePath(string $fileName): string
    {
         return Kernel::PROJECT_DIR . '/Src/View/' . $fileName;
    }

    /**
     * @param string $fileName
     * @return false|string
     */
    protected function getFileContent(string $fileName)
    {
        return file_get_contents($this->getFilePath($fileName));
    }

    /**
     * @param string $element
     * @param string $name
     * @return mixed
     */
    protected function getFunctionByName(string $element, string $name)
    {
        preg_match_all('/({% ' . $name . ' .*? %})/ms', $element, $elements);


        return $elements[0];
    }

    /**
     * @param string $element
     * @param string $name
     * @return mixed
     */
    protected function getAllFunctionsByName(string $element, string $name)
    {
        preg_match_all('/({% ' . $name . ' .*? %})/ms', $element, $elements);

        return $elements[0];
    }

    /**
     * @param string $content
     * @param string $nameFunction
     * @return string
     */
    protected function getFunctionArgument(string $content, string $nameFunction): string
    {
        return trim($this->getStringBetween($content, $nameFunction, '%}'));
    }
}