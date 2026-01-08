<?php
namespace src\Router;

use src\Controller\PublicBase;
use src\Controller\PublicHome;
use src\Controller\PublicNotFound;
use src\Factory\ServiceFactory;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
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
        $factory = new ServiceFactory(new QueryBuilder(), new QueryExecutor());

        $handlers = [
            new OriginRouter(),
            new SpecieRouter(),
            new FeatRouter(),
            new ItemRouter(),
            new RegistryRouter(),
        ];

        foreach ($handlers as $handler) {
            $controller = $handler->match($path, $factory);
            if ($controller !== null) {
                return $controller;
            }
        }

        return static::fromHome($path) ?? new PublicNotFound();
    }
}
