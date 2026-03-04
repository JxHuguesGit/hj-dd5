<?php
namespace src\Presenter\FormBuilder;

use src\Collection\Collection;
use src\Constant\Constant;
use src\Utils\Html;

class CheckboxGroupField extends FormField
{
    public function __construct(
        protected string $name,
        protected Collection $choices,
        protected array $params = []
    ) {
        parent::__construct($name, '', null, false, $this->params);
    }

    public function renderInput(): string
    {
        $content = '';

        $params = ['outerDivClass' => 'form-check d-flex align-items-center gap-2'];
        $i      = 0;
        foreach ($this->choices as $choice) {
            if ($choice->checked) {
                $params['checked'] = 'checked';
            } else {
                unset($params['checked']);
            }
            $checkboxField  = new CheckboxField($choice->slug->value, $choice->label, $choice->id, false, $params);
            $content       .= Html::getDiv(
                $checkboxField->display(),
                [Constant::CST_CLASS => 'col-4' . ($i >= 3 ? ' mt-2' : '')]
            );
            $i++;
        }

        $div = Html::getDiv($content, [Constant::CST_CLASS => 'row']);
        return Html::getBalise('fieldset', $div, [Constant::CST_CLASS => 'fieldset ' . $this->name . '-fieldset px-3 py-0']);
    }
}
