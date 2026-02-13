<?php
namespace src\Presenter\FormBuilder;

use src\Utils\Html;

class HrField extends FormField
{
    public function renderInput(): string
    {
        return '<hr/>';
    }

    public function display(): string
    {
        return $this->renderInput();
    }
}
