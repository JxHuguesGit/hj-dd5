<?php
namespace src\Factory\Compendium;

use src\Controller\Compendium\ToolCompendiumHandler;
use src\Presenter\ListPresenter\ToolListPresenter;
use src\Presenter\TableBuilder\ToolTableBuilder;

class ToolCompendiumFactory extends AbstractCompendiumFactory
{
    public function create(): ToolCompendiumHandler
    {
        return new ToolCompendiumHandler(
            $this->readerFactory->tool(),
            new ToolListPresenter($this->readerFactory->origin()),
            $this->page(new ToolTableBuilder())
        );
    }
}
