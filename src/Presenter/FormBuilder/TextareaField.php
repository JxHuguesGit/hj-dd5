<?php
namespace src\Presenter\FormBuilder;

use src\Constant\Constant;
use src\Utils\Html;

class TextareaField extends FormField
{
    public function renderInput(): string
    {
        $attrs = [
            Constant::CST_ID    => $this->getId(),
            Constant::CST_NAME  => $this->name,
            Constant::CST_CLASS => 'form-control',
            'style'             => $this->params['style'],
        ];
        if ($this->readonly) {
            $attrs['readonly'] = 'readonly';
        }

        return Html::getBalise('textarea', $this->value, $attrs);
    }
}
