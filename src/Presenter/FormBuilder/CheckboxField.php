<?php
namespace src\Presenter\FormBuilder;

use src\Constant\Bootstrap;
use src\Constant\Constant;
use src\Utils\Html;

class CheckboxField extends FormField
{
    public function renderInput(): string
    {
        $attrs = [
            Constant::CST_TYPE  => 'checkbox',
            Constant::CST_ID    => $this->getId(),
            Constant::CST_NAME  => $this->name,
            Constant::CST_VALUE => $this->value,
        ];
        if ($this->params[Constant::CST_CHECKED]) {
            $attrs[Constant::CST_CHECKED] = Constant::CST_CHECKED;
        }

        return Html::getBalise('input', '', $attrs);
    }

    public function display(): string
    {
        $strBalise = $this->renderInput();
        $strLabel  = Html::getBalise(
            Constant::CST_LABEL,
            htmlspecialchars($this->label),
            [Constant::CST_CLASS => 'w-100 py-0', 'for' => $this->getId()]
        );
        $innerDiv = Html::getDiv($strBalise . $strLabel, [Constant::CST_CLASS => 'form-floating h-100']);
        $innerDiv = Html::getDiv(
            $innerDiv,
            [
                Constant::CST_CLASS => 'checkbox checkbox-sm ajaxAction w-100',
                Constant::CST_DATA  => [
                    Constant::CST_TRIGGER => Constant::CST_CLICK,
                    Constant::CST_ACTION  => 'toggleCheckbox',
                    Constant::CST_TARGET  => $this->getId(),
                ],
            ]
        );
        return Html::getDiv(
            $innerDiv,
            [Constant::CST_CLASS => ($this->params[Constant::OUTERDIVCLASS] ?? Bootstrap::CSS_COL_12)]
        );
    }
}
