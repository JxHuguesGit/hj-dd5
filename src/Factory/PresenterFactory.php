<?php
namespace src\Factory;

use src\Presenter\Admin\CombatParticipantPresenter;
use src\Presenter\Admin\CombatPresenter;
use src\Presenter\Admin\InitiativeAdminPresenter;
use src\Presenter\Admin\MapAdminPresenter;
use src\Presenter\Admin\MapTokenAdminPresenter;
use src\Presenter\Admin\TokenAdminPresenter;
use src\Renderer\TemplateRenderer;

final class PresenterFactory
{
    public function __construct(
        private TemplateRenderer $renderer,
        private ReaderFactory $readerFactory,
    ) {}

    public function renderer(): TemplateRenderer
    {
        return $this->renderer;
    }

    public function token(): TokenAdminPresenter
    {
        return new TokenAdminPresenter(
            $this->renderer
        );
    }

    public function map(): MapAdminPresenter
    {
        return new MapAdminPresenter(
            $this->renderer
        );
    }

    public function mapToken(): MapTokenAdminPresenter
    {
        return new MapTokenAdminPresenter(
            $this->renderer
        );
    }

    public function initiative(): InitiativeAdminPresenter
    {
        return new InitiativeAdminPresenter(
            $this->renderer
        );
    }

    public function combat(): CombatPresenter
    {
        return new CombatPresenter(
            $this->readerFactory,
            $this->renderer
        );
    }

    public function combatParticipant(): CombatParticipantPresenter
    {
        return new CombatParticipantPresenter(
            $this->renderer
        );
    }
}
