<?php
namespace src\Utils;

use src\Collection\Collection;
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
        $htmlContent = '';
        foreach ($this->fields as $formField) {
            $htmlContent .= $formField->display();
        }

        return $this->renderer->render(
            Template::FORM_CARD,
            [
                'Titre',
                $htmlContent,
                'Boutons'
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

    public function addButton(): self
    {
        return $this;
    }
}
