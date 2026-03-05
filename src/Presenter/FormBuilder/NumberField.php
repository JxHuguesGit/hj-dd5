<?php
namespace src\Presenter\FormBuilder;

use src\Constant\Constant;
use src\Utils\Html;

class NumberField extends FormField
{
    public function renderInput(): string
    {
        $attrs = [
            Constant::TYPE  => 'number',
            Constant::ID    => $this->getId(),
            Constant::NAME  => $this->name,
            Constant::VALUE => $this->value,
            Constant::CLASS => 'form-control',
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
