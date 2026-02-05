<?php
namespace src\Presenter\FormBuilder;

use src\Utils\Html;

class NumberField extends FormField
{
    public function renderInput(): string
    {
        $attrs = [
            'type' => 'number',
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
