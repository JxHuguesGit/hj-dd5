<?php
namespace src\Presenter\FormBuilder;

use src\Utils\Html;

class TextField extends FormField
{
    public function renderInput(): string
    {
        $attrs = [
            'type' => 'text',
            'id'   => $this->getId(),
            'name' => $this->name,
            'value' => $this->value,
            'class' => 'form-control',
        ];
        if ($this->readonly) {
            $attrs['readonly'] = 'readonly';
        }

        return Html::getBalise('input', '', $attrs);
    }
}
