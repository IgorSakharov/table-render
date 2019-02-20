<?php

namespace Vendor\Form;

/**
 * Class FormRequirementsBuilder
 * @package Vendor\Form
 */
abstract class FormRequirementsBuilder
{
    /**
     * @var array
     */
    protected $elements = [];

    /**
     * FormRequirementsBuilder constructor.
     */
    public function __construct()
    {
        $this->configureParameters();
    }

    /**
     * @param string $name
     * @param string $roles
     * @return FormRequirementsBuilder
     */
    protected function add(string $name, string $roles): self
    {
        $this->elements[$name] = $roles;

        return $this;
    }

    /**
     * @return array
     */
    public function getFieldsNames(): array
    {
        return array_keys($this->elements);
    }

    /**
     * @param string $name
     * @return array|null
     */
    public function getRulesByName(string $name): ?string
    {
        if ($this->elements[$name]) {
            return $this->elements[$name];
        } else {
            throw new \RuntimeException('Does not exist roles for this parameter');
        }
    }

    /**
     * configure your fields
     */
    protected function configureParameters(){}
}