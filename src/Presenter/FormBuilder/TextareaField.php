<?php
namespace src\Presenter\FormBuilder;

use src\Utils\Html;

class TextareaField extends FormField
{
    public function renderInput(): string
    {
        $attrs = [
            'id'   => $this->getId(),
            'name' => $this->name,
            'class' => 'form-control',
            'style' => $this->params['style'],
        ];
        if ($this->readonly) {
            $attrs['readonly'] = 'readonly';
        }

        return Html::getBalise('textarea', $this->value, $attrs);
    }
}
