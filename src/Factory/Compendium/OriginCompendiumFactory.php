<?php
namespace src\Factory\Compendium;

use src\Controller\Compendium\OriginCompendiumHandler;
use src\Presenter\ListPresenter\OriginListPresenter;
use src\Presenter\TableBuilder\OriginTableBuilder;

class OriginCompendiumFactory extends AbstractCompendiumFactory
{
    public function create(): OriginCompendiumHandler
    {
        return new OriginCompendiumHandler(
            $this->readerFactory->origin(),
            new OriginListPresenter(
                $this->readerFactory->reference(),
                $this->serviceFactory->origin()
            ),
            $this->page(new OriginTableBuilder()),
        );
    }
}
