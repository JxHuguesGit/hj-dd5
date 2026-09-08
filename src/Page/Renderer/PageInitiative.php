<?php

namespace src\Page\Renderer;

use src\Constant\Template;
use src\Domain\Entity\Combat;
use src\Presenter\ContentBuilder\InitiativeContentBuilder;
use src\Presenter\ListPresenter\InitiativeListPresenter;
use src\Renderer\TemplateRenderer;
use src\Service\Reader\CombatParticipantReader;

class PageInitiative
{
    public function __construct(
        private Combat $combat,
        private TemplateRenderer $renderer,
        private CombatParticipantReader $participantReader,
        private InitiativeListPresenter $presenter,
        private InitiativeContentBuilder $contentBuilder
    ) {}

    public function render(): string
    {
        $contentHeader = $this->contentBuilder->buildHeader($this->combat);

        $participants = $this->participantReader
            ->participantsByCombat($this->combat->id);

        $viewData = $this->presenter->present(
            $this->combat,
            $participants
        );
        $contentHtml = $this->contentBuilder->build($viewData);

        return $this->renderer->render(
            Template::INITIATIVE_PAGE,
            [
                $contentHeader,
                $contentHtml,
            ]
        );
    }
}
