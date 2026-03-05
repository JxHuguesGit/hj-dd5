<?php
namespace src\Presenter\FormBuilder;

use src\Constant\Bootstrap as B;
use src\Constant\Constant;
use src\Utils\Html;

class CheckboxField extends FormField
{
    public function renderInput(): string
    {
        $attrs = [
            Constant::TYPE  => 'checkbox',
            Constant::ID    => $this->getId(),
            Constant::NAME  => $this->name,
            Constant::VALUE => $this->value,
        ];
        if ($this->params[Constant::CHECKED]) {
            $attrs[Constant::CHECKED] = Constant::CHECKED;
        }

        return Html::getBalise('input', '', $attrs);
    }

    public function display(): string
    {
        $strBalise = $this->renderInput();
        $strLabel  = Html::getBalise(
            Constant::LABEL,
            htmlspecialchars($this->label),
            [Constant::CLASS => 'w-100 py-0', 'for' => $this->getId()]
        );
        $innerDiv = Html::getDiv($strBalise . $strLabel, [Constant::CLASS => 'form-floating h-100']);
        $innerDiv = Html::getDiv(
            $innerDiv,
            [
                Constant::CLASS => 'checkbox checkbox-sm ajaxAction w-100',
                Constant::DATA  => [
                    Constant::TRIGGER => Constant::CLICK,
                    Constant::ACTION  => 'toggleCheckbox',
                    Constant::TARGET  => $this->getId(),
                ],
            ]
        );
        return Html::getDiv(
            $innerDiv,
            [Constant::CLASS => ($this->params[Constant::OUTERDIVCLASS] ?? B::COL_12)]
        );
    }
}
