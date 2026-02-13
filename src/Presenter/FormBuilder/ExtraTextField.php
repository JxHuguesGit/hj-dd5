<?php
namespace src\Presenter\FormBuilder;

use src\Constant\Bootstrap;
use src\Constant\Constant;

class ExtraTextField extends FormField
{
    protected mixed $extraValue = null;

    public function __construct(
        protected string $name,
        protected string $label,
        protected mixed $value = null,
        protected bool $readonly = false,
        protected array $params = []
    ) {
        $this->params = array_merge([
            'valueWidth' => Bootstrap::CSS_COL_MD_2.' mb-3',
            'extraWidth' => Bootstrap::CSS_COL_MD_4.' mb-3',
        ]);
        $this->extraValue = $params['extraValue'] ?? null;
    }

    public function display(): string
    {
        return
            (new TextField(
                $this->name,
                $this->label,
                $this->value,
                $this->readonly,
                [Constant::OUTERDIVCLASS=>$this->params['valueWidth']]
            ))->display().
            (new TextField(
                'extra['.$this->name.']',
                'Complément',
                $this->extraValue,
                $this->readonly,
                [Constant::OUTERDIVCLASS=>$this->params['extraWidth']]
            ))->display();
    }
}

