<?php
namespace src\Presenter\FormBuilder;

use src\Constant\Constant as C;
use src\Utils\Html;

class FillerField extends FormField
{
    public function renderInput(): string
    {
        return Html::getBalise('span', '&nbsp;');
    }

    public function display(): string
    {
        $strBalise = $this->renderInput();
        return Html::getDiv(
            $strBalise,
            [C::CSSCLASS => $this->params['outerDivClass'] ?? 'col-12']
        );
    }
}
