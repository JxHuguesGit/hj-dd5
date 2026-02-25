<?php
namespace src\Controller;

use src\Constant\Constant;
use src\Constant\Template;
use src\Domain\Entity;
use src\Factory\CharacterFactory;
use src\Factory\CompendiumFactory;
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
        'home',
        'character',
        'timeline',
        'compendium',
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
        $currentTab = $this->getArrParams(Constant::ONGLET, 'home');
        $currentId  = $this->getArrParams('id', '');
        $sidebar    = new AdminSidebar();
        $sidebar->setAttributes(
            $this->allowedOnglets,
            $currentTab,
            $currentId
        );
        return $sidebar->getContent();
    }

    public static function getAdminController(array $arrUri): mixed
    {
        Entity::setSharedDependencies(new QueryBuilder(), new QueryExecutor());

        $controller = new AdminPage($arrUri);
        $currentTab = $controller->getArrParams(Constant::ONGLET, 'home');
        switch ($currentTab) {
            case 'character':
                $repo       = new CharacterRepository(new QueryBuilder(), new QueryExecutor());
                $controller = new AdminCharacterPage(
                    $arrUri,
                    new CharacterFactory(
                        new CharacterServices(
                            new CharacterReader($repo),
                            new CharacterWriter($repo),
                        ),
                        new TemplateRenderer()
                    )
                );
                break;
            case 'compendium':
                $controller = new AdminCompendiumPage(
                    $arrUri,
                    new CompendiumFactory(
                        new QueryBuilder(),
                        new QueryExecutor(),
                        new TemplateRenderer()
                    )
                );
                break;
            case 'home':
            default:
                $controller = new AdminHomePage($arrUri);
                break;
        }
        return $controller;
    }
}
