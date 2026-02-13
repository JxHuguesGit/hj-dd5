<?php
namespace src\Presenter\FormBuilder;

use src\Constant\Constant;
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
            [Constant::CST_CLASS => $this->params['outerDivClass'] ?? 'col-12']
        );
    }
}
