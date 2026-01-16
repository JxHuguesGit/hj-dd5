<?php
namespace src\Router;

use src\Controller\Public\PublicBase;
use src\Controller\Public\PublicHome;
use src\Controller\Public\PublicNotFound;
use src\Factory\ReaderFactory;
use src\Factory\RepositoryFactory;
use src\Factory\ServiceFactory;
use src\Model\PageRegistry;
use src\Page\PageNotFound;
use src\Presenter\MenuPresenter;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Renderer\TemplateRenderer;
use src\Utils\Session;

class Router
{
    public static function fromHome(string $path): ?PublicBase
    {
        ////////////////////////////////////////////////////////////
        // --- Gestion de la page d'accueil ---
        if ($path === '' || $path === 'home') {
            return new PublicHome();
        }

        return null;
    }

    private static function normalizePath(string $url): string
    {
        $path = trim(parse_url($url, PHP_URL_PATH), '/');

        // Gestion éventuelle du préfixe (DD5_URL)
        if (defined('DD5_URL')) {
            return $path;
        }

        $prefix = trim(parse_url(DD5_URL, PHP_URL_PATH), '/');
        if (str_starts_with($path, $prefix)) {
            $path = trim(substr($path, strlen($prefix)), '/');
        }
        return $path;
    }

    public static function getController(): PublicBase
    {
        $path = self::normalizePath(Session::getRequestUri());
        $repositoryFactory = new RepositoryFactory(new QueryBuilder(), new QueryExecutor());
        $readerFactory     = new ReaderFactory($repositoryFactory);
        $serviceFactory    = new ServiceFactory(new QueryBuilder(), new QueryExecutor());

        $handlers = [
            new OriginRouter(),
            new SpecieRouter(),
            new FeatRouter(),
            new ItemRouter(),
            new RegistryRouter(),
        ];

        foreach ($handlers as $handler) {
            $controller = $handler->match($path, $readerFactory, $serviceFactory);
            if ($controller !== null) {
                return $controller;
            }
        }

        return static::fromHome($path)
            ?? new PublicNotFound(
                new PageNotFound(
                    new TemplateRenderer()
                ),
                new MenuPresenter(PageRegistry::getInstance()->all(), '')
            );
    }
}
