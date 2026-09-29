<?php
namespace src\Presenter\FormBuilder;

use src\Constant\Bootstrap;
use src\Constant\Constant as C;
use src\Utils\Html;

class EmptyField extends FormField
{
    public function __construct(array $params)
    {
        parent::__construct('', '', null, true, $params);
    }

    public function renderInput(): string
    {
        $attributes = [C::CSSCLASS => Bootstrap::MB3 . ' ' . ($this->params[C::CSSCLASS] ?? '')];
        return Html::getDiv(
            '',
            $attributes
        );
    }

    public function display(): string
    {
        return $this->renderInput();
    }
}
