<?php
namespace src\Presenter\FormBuilder;

use src\Constant\Bootstrap as B;
use src\Constant\Constant as C;
use src\Utils\Html;

class CheckboxField extends FormField
{
    public function renderInput(): string
    {
        $attrs = [
            C::TYPE  => 'checkbox',
            C::ID    => $this->getId(),
            C::NAME  => $this->name,
            C::VALUE => $this->value,
        ];
        if ($this->params[C::CHECKED]) {
            $attrs[C::CHECKED] = C::CHECKED;
        }

        return Html::getBalise('input', '', $attrs);
    }

    public function display(): string
    {
        $strBalise = $this->renderInput();
        $strLabel  = Html::getBalise(
            C::LABEL,
            htmlspecialchars($this->label),
            [C::CSSCLASS => 'w-100 py-0', 'for' => $this->getId()]
        );
        $innerDiv = Html::getDiv($strBalise . $strLabel, [C::CSSCLASS => 'form-floating h-100']);
        $innerDiv = Html::getDiv(
            $innerDiv,
            [
                C::CSSCLASS => 'checkbox checkbox-sm ajaxAction w-100',
                C::DATA  => [
                    C::TRIGGER => C::CLICK,
                    C::ACTION  => 'toggleCheckbox',
                    C::TARGET  => $this->getId(),
                ],
            ]
        );
        return Html::getDiv(
            $innerDiv,
            [C::CSSCLASS => ($this->params[C::OUTERDIVCLASS] ?? B::COL_12)]
        );
    }
}
