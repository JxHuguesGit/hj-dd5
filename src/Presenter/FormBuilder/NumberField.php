<?php
namespace src\Presenter\FormBuilder;

use src\Constant\Constant;
use src\Utils\Html;

class NumberField extends FormField
{
    public function renderInput(): string
    {
        $attrs = [
            Constant::CST_TYPE  => 'number',
            Constant::CST_ID    => $this->getId(),
            Constant::CST_NAME  => $this->name,
            Constant::CST_VALUE => $this->value,
            Constant::CST_CLASS => 'form-control',
        ];
        if ($this->params['step']) {
            $attrs['step'] = $this->params['step'];
        }
        if ($this->readonly) {
            $attrs['readonly'] = 'readonly';
        }

        return Html::getBalise('input', '', $attrs);
    }
}
