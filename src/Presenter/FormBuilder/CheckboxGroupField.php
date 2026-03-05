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

        $params = [Constant::OUTERDIVCLASS => 'form-check d-flex align-items-center gap-2'];
        $i      = 0;
        foreach ($this->choices as $choice) {
            if ($choice->checked) {
                $params[Constant::CHECKED] = Constant::CHECKED;
            } else {
                unset($params[Constant::CHECKED]);
            }
            $checkboxField  = new CheckboxField($choice->slug->value, $choice->label, $choice->id, false, $params);
            $content       .= Html::getDiv(
                $checkboxField->display(),
                [Constant::CLASS => 'col-4' . ($i >= 3 ? ' mt-2' : '')]
            );
            $i++;
        }

        return Html::getBalise(
            'fieldset',
            Html::getDiv($content, [Constant::CLASS => 'row']),
            [Constant::CLASS => 'fieldset ' . $this->name . '-fieldset px-3 py-0 ' . ($this->params['extraClass'] ?? '')]
        );
    }
}
