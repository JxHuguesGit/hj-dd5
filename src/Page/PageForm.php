<?php
namespace src\Page;

use src\Constant\Bootstrap;
use src\Constant\Template;
use src\Domain\Entity as DomainEntity;
use src\Presenter\FormBuilder\FormBuilderInterface;
use src\Renderer\TemplateRenderer;

class PageForm
{
    public function __construct(
        private TemplateRenderer $renderer,
        private FormBuilderInterface $formBuilder,
        private string $toastContent = '',
    ) {}

    public function render(string $menuHtml, string $title, DomainEntity $entity, ?string $modalContent = null): string
    {
        // Page complète avec menu
        return $this->renderer->render(
            Template::MAIN_PAGE,
            [$menuHtml, $this->renderAdmin($title, $entity), $modalContent]
        );
    }

    public function renderAdmin(string $title, DomainEntity $entity): string
    {
        // Construire le formulaire
        $formHtml = $this->formBuilder->build(
            $entity,
            [Bootstrap::CSS_WITH_MRGNTOP => false]
        );

        // Section centrale (titre + formulaire)
        return $this->renderer->render(
            Template::CATEGORY_PAGE,
            [$title, $formHtml->display(), $this->toastContent]
        );
    }
}
