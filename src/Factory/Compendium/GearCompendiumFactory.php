<?php
namespace src\Factory\Compendium;

use src\Controller\Compendium\GearCompendiumHandler;
use src\Presenter\ToastBuilder;

class GearCompendiumFactory extends AbstractCompendiumFactory
{
    public function create(): GearCompendiumHandler
    {
        return new GearCompendiumHandler(
            $this->writerFactory->item(),
            $this->readerFactory->item(),
            new ToastBuilder($this->renderer),
            $this->renderer
        );
    }
}
