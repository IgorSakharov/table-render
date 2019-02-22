<?php

namespace Vendor\ViewCreator\Functions;

use Vendor\ViewCreator\VariableReplaceTrait;

class ForeachFunction
{
    use VariableReplaceTrait;

    /**
     * @var array
     */
    protected $parameters;

    /**
     * @var string
     */
    protected $foreachConditions;

    /**
     * @var string
     */
    protected $fileContent;

    /**
     * ForeachFunction constructor.
     * @param string $fileContent
     * @param string $content
     * @param array $parameters
     */
    public function __construct(string $fileContent, string $content, array &$parameters)
    {
        $this->fileContent       = $fileContent;
        $this->foreachConditions = $content;
        $this->parameters        = $parameters[$this->getNameOfKey()];
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->getStringBetween($this->fileContent, $this->foreachConditions, '{% endforeach %}');
    }

    /**
     * @return string
     */
    public function replace(): string
    {
        return $this->replaceString($this->fileContent, $this->handelFunction(), $this->foreachConditions, '{% endforeach %}');
    }

    /**
     * @return string
     */
    protected function handelFunction(): string
    {
        $nameOfParameter = $this->getNameOfParameter();
        $functionBody    = $this->getBody();
        $result          = '';

        foreach ($this->parameters as $arrayParams) {
            $result .= $this->setValueForArray($functionBody,  $nameOfParameter, $arrayParams);
        }

        return $result;
    }

    /**
     * @param string $element
     * @param string $nameParameter
     * @param array $parameters
     * @return string
     */
    protected function setValueForArray(string $element, string $nameParameter, array $parameters): string
    {
        foreach ($parameters as $kay => $value) {
            $element = str_replace("{{ " . $nameParameter . "['" . $kay . "'] }}", $parameters[$kay], $element);
        }

        return $element;
    }

    /**
     * @return string
     */
    protected function getNameOfParameter(): string
    {
        return $this->getStringBetween($this->foreachConditions, 'foreach ', 'in');
    }

    /**
     * @return string
     */
    protected function getNameOfKey(): string
    {
        return $this->getStringBetween($this->foreachConditions, 'in ', ' %');
    }
}