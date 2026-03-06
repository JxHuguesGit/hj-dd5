<?php
namespace src\Presenter\FormBuilder;

use src\Constant\Bootstrap as B;
use src\Constant\Constant as C;
use src\Utils\Html;

abstract class FormField
{
    public function __construct(
        protected string $name,
        protected string $label,
        protected mixed $value = null,
        protected bool $readonly = false,
        protected array $params = [],
    ) {}

    public function getId(): string
    {return 'id_' . $this->name;}

    public function display(): string
    {
        $strBalise = $this->renderInput();
        $strLabel  = Html::getBalise(
            C::LABEL,
            htmlspecialchars($this->label),
            ['for' => $this->getId()]
        );
        $innerDiv = Html::getDiv($strBalise . $strLabel, [C::CSSCLASS => 'form-floating']);
        return Html::getDiv(
            $innerDiv,
            [C::CSSCLASS => $this->params[C::OUTERDIVCLASS] ?? B::COL_12]
        );
    }
}
