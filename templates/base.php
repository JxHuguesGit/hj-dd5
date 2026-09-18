<?php

use src\Collection\Collection;
use src\Constant\Template;
use src\Controller\Public\PublicNotFound;
use src\Factory\Controller\FeatControllerFactory;
use src\Factory\Controller\InitiativeControllerFactory;
use src\Factory\Controller\ItemControllerFactory;
use src\Factory\Controller\MapControllerFactory;
use src\Factory\Controller\OriginControllerFactory;
use src\Factory\Controller\PublicControllerFactory;
use src\Factory\Controller\SkillControllerFactory;
use src\Factory\Controller\SpecieControllerFactory;
use src\Factory\Controller\SpellControllerFactory;
use src\Factory\ReaderFactory;
use src\Factory\RepositoryFactory;
use src\Factory\ServiceFactory;
use src\Factory\WriterFactory;
use src\Model\PageRegistry;
use src\Page\Renderer\PageNotFound;
use src\Presenter\MenuPresenter;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Renderer\TemplateRenderer;
use src\Router\FeatRouter;
use src\Router\InitiativeRouter;
use src\Router\ItemRouter;
use src\Router\MapRouter;
use src\Router\OriginRouter;
use src\Router\RegistryRouter;
use src\Router\Router;
use src\Router\SkillRouter;
use src\Router\SpecieRouter;
use src\Router\SpellRouter;

if (strpos(PLUGIN_PATH, 'wamp64') !== false) {
    define('DD5_URL', 'http://localhost/');
} else {
    define('DD5_URL', 'https://dd5.jhugues.fr/');
}
define('PLUGIN_URL', 'wp-content/plugins/hj-dd5/');
define('PLUGINS_DD5', DD5_URL . PLUGIN_URL);
date_default_timezone_set('Europe/Paris');

class DD5Base
{
    public static function display(): void
    {
        PageRegistry::getInstance();

        $msgProcessError = '';
        $errorPanel      = '';
        $queryBuilder    = new QueryBuilder();
        $queryExecutor   = new QueryExecutor();
        $repository      = new RepositoryFactory($queryBuilder, $queryExecutor);
        $reader          = new ReaderFactory($repository);
        $writer          = new WriterFactory($repository);
        $service         = new ServiceFactory($reader, $writer);
        $renderer        = new TemplateRenderer();

        $router          = $router = new Router(
            new Collection([
                new OriginRouter(
                    new OriginControllerFactory($reader, $service, $renderer)
                ),
                new SpecieRouter(
                    new SpecieControllerFactory($reader, $service, $renderer)
                ),
                new SpellRouter(
                    new SpellControllerFactory($service, $renderer)
                ),
                new SkillRouter(
                    new SkillControllerFactory($reader, $service, $renderer)
                ),
                new FeatRouter(
                    new FeatControllerFactory($reader, $service, $renderer)
                ),
                new ItemRouter(
                    new ItemControllerFactory($reader, $service, $renderer)
                ),
                new MapRouter(
                    new MapControllerFactory($reader, $service, $renderer)
                ),
                new RegistryRouter(
                    new PublicControllerFactory($reader, $service, $renderer)
                ),
                new InitiativeRouter(
                    new InitiativeControllerFactory($reader, $renderer)
                ),
            ]),
            new PublicNotFound(
                new PageNotFound($renderer),
                new MenuPresenter(PageRegistry::getInstance()->all(), '')
            )
        );
        $controller      = $router->getController();

        if (DD5_URL == 'http://localhost/') {
            $srcCssFilesTpl = $controller->getRender(Template::LOCAL_CSS, [PLUGINS_DD5]);
            $srcJsFilesTpl  = $controller->getRender(Template::LOCAL_JS, [PLUGINS_DD5]);
        } else {
            $srcCssFilesTpl = $controller->getRender(Template::WWW_CSS);
            $srcJsFilesTpl  = $controller->getRender(Template::WWW_JS);
        }

        $baseTemplate = $controller->getBaseTemplate();

        if ($baseTemplate === Template::BASE_MAP || $baseTemplate === Template::BASE_INITIATIVE) {
            $attributes = [
                $controller->getTitle(),
                $srcCssFilesTpl,
                PLUGINS_DD5,
                $controller->getContentPage($msgProcessError),
                $srcJsFilesTpl,
                date('YmdHis'),
            ];
        } else {
            $attributes = [
                $controller->getTitle(),
                $srcCssFilesTpl,
                PLUGINS_DD5,
                $controller->getContentHeader(),
                $controller->getContentPage($msgProcessError),
                $controller->getContentFooter(),
                $errorPanel,
                $srcJsFilesTpl,
                date('YmdHis'),
            ];
        }

        echo $controller->getRender($baseTemplate, $attributes);
    }

}
DD5Base::display();
