<?php
namespace src\Factory\Compendium;

use src\Controller\Compendium\SpellCompendiumHandler;
use src\Presenter\FormBuilder\SpellFormBuilder;
use src\Presenter\ListPresenter\SpellListPresenter;
use src\Presenter\Modal\SpellFilterModalPresenter;
use src\Presenter\TableBuilder\SpellTableBuilder;
use src\Presenter\ToastBuilder;
use src\Service\Domain\WpPostService;

class SpellCompendiumFactory extends AbstractCompendiumFactory
{
    public function create(): SpellCompendiumHandler
    {
        return new SpellCompendiumHandler(
            $this->serviceFactory->spell(),
            new SpellListPresenter(),
            $this->renderer,
            new SpellFormBuilder(
                $this->readerFactory->spell(),
                $this->readerFactory->spellSchool(),
                $this->readerFactory->reference(),
                new WpPostService()
            )
        );
    }
}
