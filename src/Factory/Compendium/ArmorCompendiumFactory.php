<?php
namespace src\Factory\Compendium;

use src\Controller\Compendium\ArmorCompendiumHandler;
use src\Presenter\ListPresenter\ArmorListPresenter;
use src\Presenter\TableBuilder\ArmorTableBuilder;

class ArmorCompendiumFactory extends AbstractCompendiumFactory
{
    public function create(): ArmorCompendiumHandler
    {
        return new ArmorCompendiumHandler(
            $this->readerFactory->armor(),
            new ArmorListPresenter(),
            $this->page(new ArmorTableBuilder())
        );
    }
}
