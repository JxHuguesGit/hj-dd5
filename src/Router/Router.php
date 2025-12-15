<?php
namespace src\Router;

use src\Controller\PublicBase;
use src\Controller\PublicHome;
use src\Controller\PublicFeat;
use src\Controller\PublicOrigine;
use src\Controller\PublicSpecie;
use src\Controller\PublicNotFound;
use src\Factory\ServiceFactory;
use src\Model\PageRegistry;
use src\Page\PageFeat;
use src\Page\PageOrigine;
use src\Page\PageOriginList;
use src\Page\PageSpecies;
use src\Presenter\MenuPresenter;
use src\Presenter\OriginDetailPresenter;
use src\Presenter\OriginListPresenter;
use src\Presenter\RpgOriginTableBuilder;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Renderer\TemplateRenderer;
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
        
        $queryBuilder = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $factory = new ServiceFactory($queryBuilder, $queryExecutor);

        ////////////////////////////////////////////////////////////
        // --- Gestion d'une origine individuelle ---
        if (preg_match('#^origine-(.+)$#', $path, $matches)) {
            return new PublicOrigine(
                $matches[1],
                $factory->getRpgOriginService(),
                $factory->getRpgOriginQueryService(),
                new OriginDetailPresenter(),
                new PageOrigine(new TemplateRenderer()),
                new MenuPresenter(PageRegistry::getInstance()->all())
            );
        }
        ////////////////////////////////////////////////////////////

        ////////////////////////////////////////////////////////////
        // --- Gestion d'une espèce individuelle ---
        if (preg_match('#^specie-(.+)$#', $path, $matches)) {
            return new PublicSpecie($matches[1], new PageSpecies());
        }
        ////////////////////////////////////////////////////////////

        ////////////////////////////////////////////////////////////
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
        ////////////////////////////////////////////////////////////

        ////////////////////////////////////////////////////////////
        // --- Gestion d'une catégorie de matériel ---
        if (preg_match('#^equipments-(.+)$#', $path, $matches)) {
            $typeSlug = $matches[1];
            $controllerClass = 'src\\Controller\\PublicEquipment' . ucfirst($typeSlug);
            if (class_exists($controllerClass)) {
                return new $controllerClass($factory->getRpgArmorService());
            }
        }
        ////////////////////////////////////////////////////////////

        // --- Partie statique via PageRegistry ---
        $registry = PageRegistry::getInstance();
        $pageElement = $registry->get($path);

        if ($pageElement) {
            $controllerClass = 'src\\Controller\\Public' . ucfirst($pageElement->getSlug());
                        
            if (class_exists($controllerClass)) {
                return match($pageElement->getSlug()) {
                    'origines' => new $controllerClass(
                        $factory->getRpgOriginQueryService(),
                        new OriginListPresenter(),
                        new PageOriginList(
                            new TemplateRenderer(),
                            new RpgOriginTableBuilder($factory->getRpgOriginService())
                        ),
                        new MenuPresenter(PageRegistry::getInstance()->all())
                    ),
                    'feats'    => new $controllerClass($factory->getRpgFeatService()),
                    default    => new $controllerClass(),
                };
            } else {
                echo "Controller class $controllerClass does not exist.";
            }
        }

        return new PublicNotFound();
    }
}
