<?php

namespace Src\Forms;

use Vendor\Form\FormRequirementsBuilder;

/**
 * Class TableForm
 * @package Src\Forms
 */
class TableForm extends FormRequirementsBuilder
{
    /**
     * Configure form
     */
    protected function configureParameters()
    {
       $this
           ->add('text', 'str\req')
           ->add('color', 'str\req');
    }
}