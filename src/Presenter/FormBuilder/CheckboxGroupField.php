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
            $label = $choice->label;
            if ($choice->checked) {
                $params['checked'] = 'checked';
            } else {
                unset($params['checked']);
            }
            $checkboxField  = new CheckboxField($this->name . '[]', $label, $choice->id, false, $params);
            $content       .= Html::getDiv($checkboxField->display(), [Constant::CST_CLASS => 'col-4' . ($i >= 3 ? ' mt-2' : '')]);

            /*
            $content .= '
                <div class="col-4' . ($i >= 3 ? ' mt-2' : '') . '">
                    <div class="form-check d-flex align-items-center gap-2">
                        <input class="form-check-input"
                               type="checkbox"
                               id="' . $this->name . '_' . $choice->id . '"
                               name="' . $this->name . '[]"
                               value="' . $choice->id . '"
                               ' . ($choice->checked ? 'checked' : '') . '>
                        <label class="form-check-label mb-0"
                               for="' . $this->name . '_' . $choice->id . '">' . $choice->label . '</label>
                    </div>
                </div>';
            */
            $i++;
        }

        $div = Html::getDiv($content, [Constant::CST_CLASS => 'row']);
        return Html::getBalise('fieldset', $div, [Constant::CST_CLASS => 'monster-fieldset px-3 py-0']);
    }
}
