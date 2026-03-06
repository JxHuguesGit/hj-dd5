<?php
namespace src\Presenter\FormBuilder;

use src\Constant\Constant as C;
use src\Utils\Html;

class TextareaField extends FormField
{
    public function renderInput(): string
    {
        $attrs = [
            C::ID    => $this->getId(),
            C::NAME  => $this->name,
            C::CSSCLASS => 'form-control',
            'style'             => $this->params['style'],
        ];
        if ($this->readonly) {
            $attrs['readonly'] = 'readonly';
        }

        return Html::getBalise('textarea', $this->value, $attrs);
    }
}
