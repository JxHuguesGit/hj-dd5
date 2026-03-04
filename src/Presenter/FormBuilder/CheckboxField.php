<?php
namespace src\Presenter\FormBuilder;

use src\Constant\Constant;
use src\Utils\Html;

class CheckboxField extends FormField
{
    public function renderInput(): string
    {
        $attrs = [
            'type'  => 'checkbox',
            'id'    => $this->getId(),
            'name'  => $this->name,
            'value' => $this->value,
        ];
        if ($this->params['checked']) {
            $attrs['checked'] = 'checked';
        }

        return Html::getBalise('input', '', $attrs);
    }

    public function display(): string
    {
        $strBalise = $this->renderInput();
        $strLabel  = Html::getBalise(
            'label',
            htmlspecialchars($this->label),
            [Constant::CST_CLASS => 'w-100 py-0', 'for' => $this->getId()]
        );
        $innerDiv = Html::getDiv($strBalise . $strLabel, [Constant::CST_CLASS => 'form-floating h-100']);
        $innerDiv = Html::getDiv(
            $innerDiv,
            [
                Constant::CST_CLASS => 'checkbox checkbox-sm ajaxAction w-100',
                Constant::CST_DATA  => [
                    Constant::CST_TRIGGER => 'click',
                    Constant::CST_ACTION  => 'toggleCheckbox',
                    Constant::CST_TARGET  => $this->getId(),
                ],
            ]
        );
        return Html::getDiv(
            $innerDiv,
            [Constant::CST_CLASS => ($this->params['outerDivClass'] ?? 'col-12')]
        );
    }
}
