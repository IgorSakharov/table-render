<?php

namespace Vendor\ViewCreator;

use Src\Kernel;

/**
 * Class View
 * @package Vendor\ViewCreator
 */
class View
{
    /**
     * @param string $fileName
     * @param array $parameters
     * @return string
     */
    public function render(string $fileName, array $parameters = null): string
    {
        $fileContent = file_get_contents(Kernel::PROJECT_DIR . '/Src/View/' . $fileName);

        return $this->setVariableValue($fileContent, $parameters);
    }

    /**
     * @param string $fileContent
     * @param array $parameters
     * @return string
     */
    protected function setVariableValue(string $fileContent, array $parameters = null): string
    {
        if (!$parameters) {
            return $fileContent;
        }

        foreach ($parameters as $name => $value) {
            $fileContent = str_replace('{{ ' . $name . ' }}', $value, $fileContent);
        }

        return $fileContent;
    }
}