<?php
namespace src\Factory;

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
}
