<?php
namespace src\Presenter\FormBuilder;

use src\Constant\Constant as C;
use src\Utils\Html;

class FillerField extends FormField
{
    public function __construct()
    {
        parent::__construct('', '');
    }

    public function renderInput(): string
    {
        return Html::getBalise('div', '', [C::CSSCLASS => 'w-100 mb-3']);
    }

    public function display(): string
    {
        return $this->renderInput();
    }
}
