<?php
namespace src\Presenter\FormBuilder;

use src\Constant\Constant;
use src\Utils\Html;

class TextField extends FormField
{
    public function renderInput(): string
    {
        $attrs = [
            Constant::TYPE  => 'text',
            Constant::ID    => $this->getId(),
            Constant::NAME  => $this->name,
            Constant::VALUE => $this->value,
            Constant::CSSCLASS => 'form-control',
        ];
        if ($this->readonly) {
            $attrs['readonly'] = 'readonly';
        }

        return Html::getBalise('input', '', $attrs);
    }
}
