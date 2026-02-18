<?php
namespace src\Factory\Compendium;

use src\Controller\Compendium\GearCompendiumHandler;
use src\Presenter\ToastBuilder;
use src\Repository\ItemRepository;
use src\Service\Reader\ItemReader;

class GearCompendiumFactory extends AbstractCompendiumFactory
{
    public function create(): GearCompendiumHandler
    {
        return new GearCompendiumHandler(
            $this->repo(ItemRepository::class),
            $this->reader(ItemReader::class, ItemRepository::class),
            new ToastBuilder($this->renderer),
            $this->renderer
        );
    }
}
