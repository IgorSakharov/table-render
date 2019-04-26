<?php

namespace Vendor\Form;

use Vendor\Request\Request;

/**
 * Class FormParameterChecker
 * @package Vendor\Form
 */
class FormParameterChecker
{
    /**
     * @param Request $request
     * @param FormRequirementsBuilder $formRequirementsBuilder
     * @return bool
     */
    public function checkParameters(Request $request, FormRequirementsBuilder $formRequirementsBuilder): bool
    {
        $status = true;

        foreach ($formRequirementsBuilder->getFieldsNames() as $fieldsName) {
            $roles = $formRequirementsBuilder->getRulesByName($fieldsName);

            if ($request->get($fieldsName) && preg_match('req', $roles)) {
                throw new \RuntimeException('Parameter %s must to exist', $fieldsName);
            }
            if (preg_match('int', $roles)) {
                $status = $this->isInteger($request->get($fieldsName));
            }
            if (preg_match('str', $roles)) {
                $status = $this->isString($request->get($fieldsName));
            }
            if (preg_match('double', $roles)) {
                $status = $this->isDouble($request->get($fieldsName));
            }
        }

        if (!$status) {
            throw new \RuntimeException('Parameters does not right . Check please your form rules');
        }

        return $status;
    }

    /**
     * @param $value
     * @return bool
     */
    protected function isString($value): bool
    {
        return is_string($value);
    }

    /**
     * @param $value
     * @return bool
     */
    protected function isInteger($value): bool
    {
        return is_integer($value);
    }

    /**
     * @param $value
     * @return bool
     */
    protected function isDouble($value): bool
    {
        return is_double($value);
    }
}