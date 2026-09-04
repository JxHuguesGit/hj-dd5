<?php
namespace src\Factory;

use src\Presenter\Admin\CombatParticipantPresenter;
use src\Presenter\Admin\CombatPresenter;
use src\Presenter\Admin\InitiativeAdminPresenter;
use src\Presenter\Admin\MapAdminPresenter;
use src\Presenter\Admin\MapTokenAdminPresenter;
use src\Presenter\Admin\TokenAdminPresenter;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Renderer\TemplateRenderer;

final class PresenterFactory
{
    public function token(): TokenAdminPresenter
    {
        return new TokenAdminPresenter(
            new TemplateRenderer()
        );
    }

    public function map(): MapAdminPresenter
    {
        return new MapAdminPresenter(
            new TemplateRenderer()
        );
    }

    public function mapToken(): MapTokenAdminPresenter
    {
        return new MapTokenAdminPresenter(
            new TemplateRenderer()
        );
    }

    public function initiative(): InitiativeAdminPresenter
    {
        return new InitiativeAdminPresenter(
            new TemplateRenderer()
        );
    }

    public function combat(): CombatPresenter
    {
        return new CombatPresenter(
            new ReaderFactory(
                new RepositoryFactory(
                    new QueryBuilder(),
                    new QueryExecutor()
                )
            ),
            new TemplateRenderer()
        );
    }

    public function combatParticipant(): CombatParticipantPresenter
    {
        return new CombatParticipantPresenter(
            new TemplateRenderer()
        );
    }
}
