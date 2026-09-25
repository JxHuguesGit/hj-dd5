<?php
namespace src\Factory\Compendium;

use src\Controller\Compendium\SpellCompendiumHandler;
use src\Presenter\ListPresenter\SpellListPresenter;
use src\Presenter\Modal\SpellFilterModalPresenter;
use src\Presenter\TableBuilder\SpellTableBuilder;
use src\Presenter\ToastBuilder;

class SpellCompendiumFactory extends AbstractCompendiumFactory
{
    public function create(): SpellCompendiumHandler
    {
        return new SpellCompendiumHandler(
            $this->serviceFactory->spell(),
            new SpellListPresenter(),
            $this->renderer,
        );
    }
}
