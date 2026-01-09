<?php
namespace src\Router;

use src\Constant\Constant;
use src\Controller\PublicBase;
use src\Controller\PublicSpecie;
use src\Factory\ReaderFactory;
use src\Factory\ServiceFactory;
use src\Presenter\MenuPresenter;
use src\Renderer\TemplateRenderer;
use src\Model\PageRegistry;
use src\Page\PageSpecie;
use src\Presenter\SpeciesDetailPresenter;

class SpecieRouter
{
    public function match(string $path, ReaderFactory $factory): ?PublicBase
    {
        ////////////////////////////////////////////////////////////
        // --- Gestion d'une espèce individuelle ---
        if (!preg_match('#^specie-(.+)$#', $path, $matches)) {
            return null;
        }

        return new PublicSpecie(
            $matches[1] ?? '',
            $factory->species(),
            new SpeciesDetailPresenter(),
            new PageSpecie(new TemplateRenderer()),
            new MenuPresenter(PageRegistry::getInstance()->all(), Constant::SPECIES),
        );
    }
}
