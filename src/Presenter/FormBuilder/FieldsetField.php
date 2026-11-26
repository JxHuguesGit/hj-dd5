<?php

namespace src\Presenter\FormBuilder;

use src\Constant\Constant as C;
use src\Utils\Html;

class FieldsetField extends FormField
{
    private array $innerFields = [];

    public function __construct(
        private string $title,
        private bool $collapsible = false,
        array $params = []
    ) {
        parent::__construct('', '', null, false, $params);
    }

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

        if ($this->params['hasLegend']) {
            $legend = Html::getBalise('legend', htmlspecialchars($this->title), [
                C::CSSCLASS => C::AJAXACTION,
                C::DATA  => [
                    C::TRIGGER => C::CLICK,
                    C::ACTION  => 'collapse',
                ],
            ]);
        } else {
            $legend = '';
        }

        $attrs = [
            C::CSSCLASS => $this->params[C::CSSCLASS] ?? 'monster-fieldset row mb-4'
        ];
        if ($this->collapsible) {
            $attrs[C::CSSCLASS] .= ' collapsible';
        }

        return Html::getBalise('fieldset', $legend . $content, $attrs);
    }
}
