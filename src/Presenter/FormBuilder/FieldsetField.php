<?php
namespace src\Presenter\FormBuilder;

use src\Constant\Constant as C;
use src\Utils\Html;

class FieldsetField extends FormField
{
    private string $title;
    private array $innerFields = [];
    private bool $collapsible;

    public function __construct(string $title, bool $collapsible = false)
    {
        $this->title       = $title;
        $this->collapsible = $collapsible;
        parent::__construct('', '', null, false, []);
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

        $legend = Html::getBalise('legend', htmlspecialchars($this->title), [
            C::CSSCLASS => C::AJAXACTION,
            C::DATA  => [
                C::TRIGGER => C::CLICK,
                C::ACTION  => 'collapse',
            ],
        ]);

        $attrs = [C::CSSCLASS => 'monster-fieldset row mb-4'];
        if ($this->collapsible) {
            $attrs[C::CSSCLASS] .= ' collapsible';
        }

        return Html::getBalise('fieldset', $legend . $content, $attrs);
    }
}
