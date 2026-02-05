<?php
namespace src\Utils;

use src\Collection\Collection;
use src\Constant\Bootstrap;
use src\Constant\Constant;
use src\Constant\Template;
use src\Presenter\FormBuilder\FormField;
use src\Renderer\TemplateRenderer;

class Form
{
    private ?Collection $fields = null;

    public function __construct(
        protected TemplateRenderer $renderer,
        private array $formAttributes,
    ) {}

    public function display(): string
    {
        $formContent = '';
        foreach ($this->fields as $formField) {
            $formContent .= $formField->display();
        }

        return $this->renderer->render(
            Template::FORM_CARD,
            [
                $this->formAttributes[Constant::CST_TITLE],
                $formContent,
                implode(' ', $this->formAttributes['buttons'])
            ]
        );
    }

    public function addField(FormField $formField): self
    {
        if ($this->fields === null) {
            $this->fields = new Collection();
        }
        $this->fields->add($formField);
        return $this;
    }

    public function addCancel(string $cancelUrl): self
    {
        $this->formAttributes['buttons'][] = Html::getLink(
            'Annuler',
            $cancelUrl,
            'btn btn-sm btn-secondary ' . Bootstrap::CSS_TEXT_WHITE);
        return $this;
    }
    public function addButton(string $label, string $type, array $params): self
    {
        $params['type'] = $type;
        if (!isset($this->formAttributes['buttons'])) {
            $this->formAttributes['buttons'] = [];
        }
        $this->formAttributes['buttons'][] = Html::getBalise('button', $label, $params);
        return $this;
    }
}
