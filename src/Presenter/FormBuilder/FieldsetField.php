<?php
namespace src\Presenter\FormBuilder;

use src\Constant\Constant;
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
            Constant::CST_CLASS => Constant::CST_AJAXACTION,
            Constant::CST_DATA  => [
                Constant::CST_TRIGGER => Constant::CST_CLICK,
                Constant::CST_ACTION  => 'collapse',
            ],
        ]);

        $attrs = [Constant::CST_CLASS => 'monster-fieldset row mb-4'];
        if ($this->collapsible) {
            $attrs[Constant::CST_CLASS] .= ' collapsible';
        }

        return Html::getBalise('fieldset', $legend . $content, $attrs);
    }
}
