<?php

namespace Vendor\Form;

use Vendor\Request\Request;

/**
 * Class BaseForm
 * @package Vendor\Form
 */
class BaseForm
{
    /**
     * @var array
     */
    protected $formData;

    /**
     * @var FormParameterChecker
     */
    protected $checker;

    /**
     * @var FormRequirementsBuilder
     */
    protected $formBuilder;

    /**
     * @var Request
     */
    protected $request;

    /**
     * BaseForm constructor.
     * @param Request $request
     * @param FormRequirementsBuilder $formRequirementsBuilder
     * @throws \Exception
     */
    public function __construct(Request $request, FormRequirementsBuilder $formRequirementsBuilder)
    {
        $this->request     = $request;
        $this->formBuilder = $formRequirementsBuilder;
        $this->checker     = new FormParameterChecker();

        $this->checkParametersRequest();
    }

    /**
     * @throws \Exception
     */
    protected function checkParametersRequest(): void
    {
        if ($this->checker->checkParameters($this->request, $this->formBuilder)) {
            foreach ($this->formBuilder->getFieldsNames() as $fieldsName) {
                $this->formData[$fieldsName] = $this->request->get($fieldsName);
            }
        } else {
            throw new \Exception('Request does not right. Check it please');
        }
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->formData;
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function getDataByName(string $name)
    {
        return $this->formData[$name];
    }
}