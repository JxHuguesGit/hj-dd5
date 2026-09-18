<?php
namespace src\Factory\Compendium;

use src\Controller\Compendium\SpellCompendiumHandler;
use src\Presenter\ListPresenter\SpellListPresenter;
use src\Presenter\Modal\SpellFilterModalPresenter;
use src\Presenter\TableBuilder\SpellTableBuilder;

class SpellCompendiumFactory extends AbstractCompendiumFactory
{
    public function create(): SpellCompendiumHandler
    {
        $referenceReader = $this->readerFactory->reference();
        return new SpellCompendiumHandler(
            $this->serviceFactory->spell(),
            new SpellListPresenter(
                $referenceReader
            ),
            $this->page(new SpellTableBuilder()),
            new SpellFilterModalPresenter(
                $referenceReader,
                $this->renderer
            )
        );
    }
}
