<?php
namespace src\Presenter\FormBuilder;

use src\Constant\Constant;
use src\Utils\Html;

class TextareaField extends FormField
{
    public function renderInput(): string
    {
        $attrs = [
            Constant::ID    => $this->getId(),
            Constant::NAME  => $this->name,
            Constant::CLASS => 'form-control',
            'style'             => $this->params['style'],
        ];
        if ($this->readonly) {
            $attrs['readonly'] = 'readonly';
        }

        return Html::getBalise('textarea', $this->value, $attrs);
    }
}
