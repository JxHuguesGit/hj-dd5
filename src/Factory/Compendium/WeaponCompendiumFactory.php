<?php
namespace src\Factory\Compendium;

use src\Controller\Compendium\WeaponCompendiumHandler;
use src\Presenter\ListPresenter\WeaponListPresenter;
use src\Presenter\TableBuilder\WeaponTableBuilder;
use src\Repository\{WeaponPropertyValueRepository, WeaponRepository};
use src\Service\Domain\WpPostService;
use src\Service\Formatter\WeaponPropertiesFormatter;
use src\Service\Reader\{WeaponPropertyValueReader, WeaponReader};

class WeaponCompendiumFactory extends AbstractCompendiumFactory
{
    public function create(): WeaponCompendiumHandler
    {
        return new WeaponCompendiumHandler(
            $this->reader(WeaponReader::class, WeaponRepository::class),
            new WeaponListPresenter(
                new WpPostService(),
                new WeaponPropertiesFormatter(),
                $this->reader(WeaponPropertyValueReader::class, WeaponPropertyValueRepository::class)
            ),
            $this->page(new WeaponTableBuilder())
        );
    }
}
