<?php
namespace src\Factory\Compendium;

use src\Controller\Compendium\WeaponCompendiumHandler;
use src\Presenter\ListPresenter\WeaponListPresenter;
use src\Presenter\TableBuilder\WeaponTableBuilder;

class WeaponCompendiumFactory extends AbstractCompendiumFactory
{
    public function create(): WeaponCompendiumHandler
    {
        return new WeaponCompendiumHandler(
            $this->readerFactory->weapon(),
            new WeaponListPresenter(
                $this->serviceFactory->weaponFormatter()
            ),
            $this->page(new WeaponTableBuilder())
        );
    }
}
