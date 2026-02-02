<?php
namespace src\Router;

use src\Constant\Constant;
use src\Constant\Routes;
use src\Controller\Public\PublicBase;
use src\Controller\Public\PublicSpecie;
use src\Factory\ReaderFactory;
use src\Factory\ServiceFactory;
use src\Model\PageRegistry;
use src\Page\PageSpecie;
use src\Presenter\MenuPresenter;
use src\Presenter\Detail\SpeciesDetailPresenter;
use src\Renderer\TemplateRenderer;
use src\Service\Page\SpeciePageService;

class SpecieRouter
{
    public function __construct(
        private ReaderFactory $factory,
        private ServiceFactory $serviceFactory
    ) {}
    
    public function match(string $path): ?PublicBase
    {
        ////////////////////////////////////////////////////////////
        // --- Gestion d'une espèce individuelle ---
        if (!preg_match(Routes::SPECIE_PATTERN, $path, $matches)) {
            return null;
        }

        return new PublicSpecie(
            $matches[1] ?? '',
            $this->factory->species(),
            new SpeciePageService($this->serviceFactory->specie(), $this->factory->species()),
            new SpeciesDetailPresenter(
                $this->serviceFactory->wordPress()
            ),
            new PageSpecie(new TemplateRenderer()),
            new MenuPresenter(PageRegistry::getInstance()->all(), Constant::SPECIES),
        );
    }
}
