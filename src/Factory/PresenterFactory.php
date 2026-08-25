<?php
namespace src\Factory;

use src\Presenter\Admin\InitiativeAdminPresenter;
use src\Presenter\Admin\MapAdminPresenter;
use src\Presenter\Admin\MapTokenAdminPresenter;
use src\Presenter\Admin\TokenAdminPresenter;
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
}
