<?php
namespace src\Factory\Controller;

use src\Constant\Constant as C;
use src\Controller\Public\PublicSpell;
use src\Factory\ServiceFactory;
use src\Model\PageRegistry;
use src\Page\Renderer\PageSpell;
use src\Presenter\ContentBuilder\SpellDetailContentBuilder;
use src\Presenter\Detail\SpellDetailPresenter;
use src\Presenter\MenuPresenter;
use src\Renderer\TemplateRenderer;
use src\Service\Page\SpellPageService;

class SpellControllerFactory
{
    public function __construct(
        private ServiceFactory $serviceFactory,
        private TemplateRenderer $renderer
    ) {}

    public function createDetailController(string $slug): PublicSpell
    {
        $spellService = $this->serviceFactory->spell();
        $spellDetailPresenter = new SpellDetailPresenter();
        return new PublicSpell(
            $slug,
            new MenuPresenter(PageRegistry::getInstance()->all(), C::SPELLS),
            new PageSpell(
                $this->renderer,
                new SpellDetailContentBuilder()
            ),
            $spellService,
            new SpellPageService($spellService, $spellDetailPresenter)
        );
    }
}
