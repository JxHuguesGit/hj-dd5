<?php
namespace src\Factory\Controller;

use src\Constant\Constant;
use src\Controller\Public\PublicSpell;
use src\Factory\{ReaderFactory, ServiceFactory};
use src\Model\PageRegistry;
use src\Page\PageSpell;
use src\Presenter\Detail\SpellDetailPresenter;
use src\Presenter\MenuPresenter;
use src\Renderer\TemplateRenderer;
use src\Service\Domain\SpellService;
use src\Service\Page\SpellPageService;

class SpellControllerFactory
{
    public function __construct(
        private ReaderFactory $readerFactory,
        private ServiceFactory $serviceFactory,
        private TemplateRenderer $renderer
    ) {}

    public function createDetailController(string $slug): PublicSpell
    {
        // Supprimer l'alerte Sonar
        unset($this->readerFactory);

        $spellService = new SpellService($this->serviceFactory->wordPress());
        $spellDetailPresenter = new SpellDetailPresenter();
        return new PublicSpell(
            $slug,
            new MenuPresenter(PageRegistry::getInstance()->all(), Constant::SPELLS),
            new PageSpell($this->renderer),
            $spellService,
            new SpellPageService($spellService, $spellDetailPresenter),
            $spellDetailPresenter
        );
    }
}
