<?php
namespace src\Router;

use src\Controller\PublicBase;
use src\Controller\PublicHome;
use src\Controller\PublicFeat;
use src\Controller\PublicOrigine;
use src\Controller\PublicSpecie;
use src\Controller\PublicNotFound;
use src\Model\PageRegistry;
use src\Page\PageFeat;
use src\Page\PageOrigine;
use src\Page\PageSpecies;
use src\Utils\Session;

class Router
{
    public static function getController(): PublicBase
    {
        $path = trim(parse_url(Session::getRequestUri(), PHP_URL_PATH), '/');

        // Gestion éventuelle du préfixe (DD5_URL)
        if (defined('DD5_URL')) {
            $prefix = trim(parse_url(DD5_URL, PHP_URL_PATH), '/');
            if (str_starts_with($path, $prefix)) {
                $path = trim(substr($path, strlen($prefix)), '/');
            }
        }

        if ($path === '' || $path === 'home') {
            return new PublicHome();
        }

        // --- Gestion d'une origine individuelle ---
        if (preg_match('#^origine-(.+)$#', $path, $matches)) {
            return new PublicOrigine($matches[1], new PageOrigine());
        }

        // --- Gestion d'une espèce individuelle ---
        if (preg_match('#^specie-(.+)$#', $path, $matches)) {
            return new PublicSpecie($matches[1], new PageSpecies());
        }

        // --- Gestion d'une catégorie de dons ---
        if (preg_match('#^feats-(.+)$#', $path, $matches)) {
            $typeSlug = $matches[1];
            $controllerClass = 'src\\Controller\\PublicFeat' . ucfirst($typeSlug);
            if (class_exists($controllerClass)) {
                return new $controllerClass();
            }
        }

        // --- Gestion d'un don individuel ---
        if (preg_match('#^feat-(.+)$#', $path, $matches)) {
            return new PublicFeat($matches[1], new PageFeat());
        }

        // --- Partie statique via PageRegistry ---
        $registry = PageRegistry::getInstance();
        $pageElement = $registry->get($path);

        if ($pageElement) {
            // Convention : contrôleur = Public + ucfirst(slug)
            $controllerClass = 'src\\Controller\\Public' . ucfirst($pageElement->getSlug());
            if (class_exists($controllerClass)) {
                return new $controllerClass();
            } else {
                echo "Controller class $controllerClass does not exist.";
            }
        }

/*
        $patterns = [
            '#^origine/([^/]+)$#' => PublicOrigines::class,
            '#^classe/([^/]+)$#'  => PublicClasses::class,
            '#^don/([^/]+)$#'     => PublicDons::class,
            '#^sort/([^/]+)$#'    => PublicSorts::class,
        ];
*/
        return new PublicNotFound();
    }
}
