<?php
namespace src\Presenter\Modal;

use src\Constant\Template;
use src\Renderer\TemplateRenderer;

class MonsterFilterModalPresenter implements ModalPresenter
{
    public function __construct(
        private TemplateRenderer $renderer,
    ) {}

    public function render(): string
    {
        // TODO : à implémenter

        $attrContent = [];

        $modalContent = $this->renderer->render(
            Template::MONSTER_FILTER_MODAL,
            $attrContent
        );

        $attributes = [
            'monsterFilter',
            'Monstres - Filtres',
            $modalContent,
            'Filtrer',
        ];

        return $this->renderer->render(
            Template::MAIN_MODAL,
            $attributes
        );
    }
}
