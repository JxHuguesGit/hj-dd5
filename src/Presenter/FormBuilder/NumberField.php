<?php
namespace src\Presenter\FormBuilder;

use src\Constant\Constant as C;
use src\Utils\Html;

class NumberField extends FormField
{
    public function renderInput(): string
    {
        $attrs = [
            C::TYPE  => 'number',
            C::ID    => $this->getId(),
            C::NAME  => $this->name,
            C::VALUE => $this->value,
            C::CSSCLASS => 'form-control',
            'step' => $this->params['step'] ?? 1,
        ];
        if ($this->readonly) {
            $attrs['readonly'] = 'readonly';
        }

        return Html::getBalise('input', '', $attrs);
    }
}
