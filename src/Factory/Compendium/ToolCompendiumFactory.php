<?php
namespace src\Factory\Compendium;

use src\Controller\Compendium\ToolCompendiumHandler;
use src\Presenter\ListPresenter\ToolListPresenter;
use src\Presenter\TableBuilder\ToolTableBuilder;
use src\Repository\{OriginRepository, ToolRepository};
use src\Service\Reader\OriginReader;

class ToolCompendiumFactory extends AbstractCompendiumFactory
{
    public function create(): ToolCompendiumHandler
    {
        return new ToolCompendiumHandler(
            $this->repo(ToolRepository::class),
            new ToolListPresenter($this->reader(OriginReader::class, OriginRepository::class)),
            $this->page(new ToolTableBuilder())
        );
    }
}
