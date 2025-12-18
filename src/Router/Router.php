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
use src\Page\PageArmorList;
use src\Page\PageFeat;
use src\Page\PageOrigine;
use src\Page\PageOriginList;
use src\Page\PageSpecie;
use src\Page\PageSpecies;
use src\Page\PageSpeciesList;
use src\Page\PageWeaponList;
use src\Presenter\ArmorListPresenter;
use src\Presenter\MenuPresenter;
use src\Presenter\FeatDetailPresenter;
use src\Presenter\OriginDetailPresenter;
use src\Presenter\OriginListPresenter;
use src\Presenter\RpgArmorTableBuilder;
use src\Presenter\SpeciesDetailPresenter;
use src\Presenter\SpeciesListPresenter;
use src\Presenter\RpgOriginTableBuilder;
use src\Presenter\RpgSpeciesTableBuilder;
use src\Presenter\RpgWeaponTableBuilder;
use src\Presenter\WeaponListPresenter;
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
                new MenuPresenter(PageRegistry::getInstance()->all(), 'origines')
            );
        }
        ////////////////////////////////////////////////////////////

        ////////////////////////////////////////////////////////////
        // --- Gestion d'une espèce individuelle ---
        if (preg_match('#^specie-(.+)$#', $path, $matches)) {
            return new PublicSpecie(
                $matches[1],
                $factory->getRpgSpeciesService(),
                $factory->getRpgSpeciesQueryService(),
                new SpeciesDetailPresenter(),
                new PageSpecie(new TemplateRenderer()),
                new MenuPresenter(PageRegistry::getInstance()->all(), 'species'),
            );
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
            return new PublicFeat(
                $matches[1],
                $factory->getRpgFeatService(),
                $factory->getRpgFeatQueryService(),
                new FeatDetailPresenter(),
                new PageFeat(new TemplateRenderer()),
                new MenuPresenter(PageRegistry::getInstance()->all(), 'feats')
            );
        }
        ////////////////////////////////////////////////////////////

        ////////////////////////////////////////////////////////////
        // --- Gestion d'une catégorie de matériel ---
        if (preg_match('#^items-(.+)$#', $path, $matches)) {
            $typeSlug = $matches[1];
            $controllerClass = 'src\\Controller\\PublicItem' . ucfirst($typeSlug);
            if (class_exists($controllerClass)) {
                return match($typeSlug) {
                    'armor' => new $controllerClass(
                        $factory->getRpgArmorQueryService(),
                        new ArmorListPresenter(),
                        new PageArmorList(
                            new TemplateRenderer(),
                            new RpgArmorTableBuilder()
                        ),
                        new MenuPresenter(PageRegistry::getInstance()->all(), 'items')
                    ),
                    'weapon' => new $controllerClass(
                        $factory->getRpgWeaponQueryService(),
                        new WeaponListPresenter(),
                        new PageWeaponList(
                            new TemplateRenderer(),
                            new RpgWeaponTableBuilder()
                        ),
                        new MenuPresenter(PageRegistry::getInstance()->all(), 'items')
                    ),
                    default    => new $controllerClass(),
                };
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
                        new MenuPresenter(PageRegistry::getInstance()->all(), 'origines')
                    ),
                    'species' => new $controllerClass(
                        $factory->getRpgSpeciesQueryService(),
                        new SpeciesListPresenter(),
                        new PageSpeciesList(
                            new TemplateRenderer(),
                            new RpgSpeciesTableBuilder($factory->getRpgSpeciesService())
                        ),
                        new MenuPresenter(PageRegistry::getInstance()->all(), 'species')
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
