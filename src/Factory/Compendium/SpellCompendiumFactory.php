<?php
namespace src\Factory\Compendium;

use src\Controller\Compendium\SpellCompendiumHandler;
use src\Presenter\ListPresenter\SpellListPresenter;
use src\Presenter\Modal\SpellFilterModalPresenter;
use src\Presenter\TableBuilder\SpellTableBuilder;
use src\Renderer\TemplateRenderer;
use src\Service\Domain\SpellService;
use src\Service\Domain\WpPostService;

class SpellCompendiumFactory extends AbstractCompendiumFactory
{
    public function create(): SpellCompendiumHandler
    {
        return new SpellCompendiumHandler(
            new SpellService(new WpPostService()),
            new SpellListPresenter(),
            $this->page(new SpellTableBuilder()),
            new SpellFilterModalPresenter(new TemplateRenderer())
        );
    }
}
