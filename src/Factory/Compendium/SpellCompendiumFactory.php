<?php
namespace src\Factory\Compendium;

use src\Controller\Compendium\SpellCompendiumHandler;
use src\Presenter\ListPresenter\SpellListPresenter;
use src\Presenter\TableBuilder\SpellTableBuilder;
use src\Service\Domain\{SpellService, WpPostService};

class SpellCompendiumFactory extends AbstractCompendiumFactory
{
    public function create(): SpellCompendiumHandler
    {
        return new SpellCompendiumHandler(
            new SpellService(new WpPostService()),
            new SpellListPresenter(),
            $this->page(new SpellTableBuilder())
        );
    }
}
