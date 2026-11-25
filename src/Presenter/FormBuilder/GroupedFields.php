<?php

namespace src\Presenter\FormBuilder;

use src\Constant\Constant as C;
use src\Utils\Html;

class GroupedFields extends FormField
{
    private array $innerFields = [];

    public function addField(FormField $field): self
    {
        $this->innerFields[] = $field;
        return $this;
    }

    public function display(): string
    {
        $content = '';

        foreach ($this->innerFields as $field) {
            $content .= $field->display();
        }

        $attrs = [
            C::CSSCLASS => 'col-md-6 mb-3 d-flex'
        ];

        return Html::getSpan($content, $attrs);
    }
}
