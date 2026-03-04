<?php
namespace src\Controller;

use src\Constant\Constant;
use src\Constant\Template;
use src\Domain\Entity;
use src\Factory\CharacterFactory;
use src\Factory\CompendiumFactory;
use src\Presenter\MenuPresenter\CharacterMenuPresenter;
use src\Presenter\MenuPresenter\CompendiumMenuPresenter;
use src\Presenter\MenuPresenter\TimelineMenuPresenter;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Renderer\TemplateRenderer;
use src\Repository\CharacterRepository;
use src\Service\Domain\CharacterServices;
use src\Service\Reader\CharacterReader;
use src\Service\Writer\CharacterWriter;

class AdminPage extends Utilities
{
    private array $allowedOnglets = [
        Constant::HOME,
        Constant::ONG_CHARACTER,
        Constant::ONG_TIMELINE,
        Constant::ONG_COMPENDIUM,
    ];

    public function getAdminContentPage(string $content): string
    {
        Entity::setSharedDependencies(new QueryBuilder(), new QueryExecutor());

        $attributes = [
            'Hugues Joneaux',
            $this->getSidebar(),
            $content,
            PLUGINS_DD5,
        ];
        return $this->getRender(Template::ADMINBASE, $attributes);
    }

    protected function getSidebar(): string
    {
        $currentTab = $this->getArrParams(Constant::ONGLET, Constant::HOME);
        $currentId  = $this->getArrParams(Constant::CST_ID, '');

        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $reader        = new CharacterReader(new CharacterRepository($queryBuilder, $queryExecutor));
        $sidebar       = new AdminSidebar(
            new CharacterMenuPresenter($reader),
            new TimelineMenuPresenter(),
            new CompendiumMenuPresenter(),
            fn($tpl, $attr) => $this->getRender($tpl, $attr),
            $this->allowedOnglets,
            $currentTab,
            $currentId
        );
        return $sidebar->getContent();
    }

    public static function getAdminController(array $arrUri): mixed
    {
        $qb       = new QueryBuilder();
        $qe       = new QueryExecutor();
        $renderer = new TemplateRenderer();
        Entity::setSharedDependencies($qb, $qe);

        $controller = new AdminPage($arrUri);
        $currentTab = $controller->getArrParams(Constant::ONGLET, Constant::HOME);
        switch ($currentTab) {
            case Constant::ONG_CHARACTER:
                $repo       = new CharacterRepository($qb, $qe);
                $controller = new AdminCharacterPage(
                    $arrUri,
                    new CharacterFactory(
                        new CharacterServices(
                            new CharacterReader($repo),
                            new CharacterWriter($repo),
                        ),
                        $renderer
                    )
                );
                break;
            case Constant::ONG_COMPENDIUM:
                $controller = new AdminCompendiumPage(
                    $arrUri,
                    new CompendiumFactory(
                        $qb,
                        $qe,
                        $renderer
                    )
                );
                break;
            case Constant::HOME:
            default:
                $controller = new AdminHomePage($arrUri);
                break;
        }
        return $controller;
    }
}
