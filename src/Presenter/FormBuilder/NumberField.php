<?php
namespace src\Presenter\FormBuilder;

use src\Constant\Constant;
use src\Utils\Html;

class NumberField extends FormField
{
    public function getType(): string
    {
        return 'number';
    }

    public function display(): string
    {
        $readonly = $this->isReadonly() ? 'readonly' : '';

        $strLabel = Html::getBalise(
            'label',
            htmlspecialchars($this->getLabel()),
            ['for' => $this->getId()]
        );

        $strBalise = Html::getBalise(
            'input',
            '',
            [
                'type' => $this->getType(),
                'id'   => $this->getId(),
                'name' => $this->getName(),
                'value' => $this->getValue(),
                $readonly => $readonly
            ]
        );

        return Html::getDiv(
            $strLabel . ' ' . $strBalise,
            [Constant::CST_CLASS => 'mb-3']
        );
    }
}
