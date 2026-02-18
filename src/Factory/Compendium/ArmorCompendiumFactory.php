<?php
namespace src\Factory\Compendium;

use src\Controller\Compendium\ArmorCompendiumHandler;
use src\Presenter\ListPresenter\ArmorListPresenter;
use src\Presenter\TableBuilder\ArmorTableBuilder;
use src\Repository\ArmorRepository;

class ArmorCompendiumFactory extends AbstractCompendiumFactory
{
    public function create(): ArmorCompendiumHandler
    {
        return new ArmorCompendiumHandler(
            $this->repo(ArmorRepository::class),
            new ArmorListPresenter(),
            $this->page(new ArmorTableBuilder())
        );
    }
}
