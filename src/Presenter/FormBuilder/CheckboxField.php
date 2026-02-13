<?php
namespace src\Presenter\FormBuilder;

use src\Constant\Constant;
use src\Utils\Html;

class CheckboxField extends FormField
{
    public function renderInput(): string
    {
        $attrs = [
            'type' => 'checkbox',
            'id'   => $this->getId(),
            'name' => $this->name,
        ];
        if ($this->value==1) {
            $attrs['checked'] = 'checked';
        }

        return Html::getBalise('input', '', $attrs);
    }

    public function display(): string
    {
        $strBalise = $this->renderInput();
        $strLabel = Html::getBalise(
            'label',
            htmlspecialchars($this->label),
            [Constant::CST_CLASS=>'w-100', 'for' => $this->getId()]
        );
        $innerDiv = Html::getDiv($strBalise.$strLabel, [Constant::CST_CLASS=>'form-floating h-100']);
        $innerDiv = Html::getDiv(
            $innerDiv,
            [
                Constant::CST_CLASS => 'checkbox ajaxAction',
                Constant::CST_DATA  => [
                    Constant::CST_TRIGGER => 'click',
                    Constant::CST_ACTION  => 'toggleCheckbox',
                    Constant::CST_TARGET  => $this->getId()
                ]
            ]
        );
        return Html::getDiv(
            $innerDiv,
            [Constant::CST_CLASS => ($this->params['outerDivClass'] ?? 'col-12')]
        );
    }
}

