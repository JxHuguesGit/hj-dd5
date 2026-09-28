<?php
namespace src\Factory\Compendium;

use src\Controller\Compendium\SpellCompendiumHandler;
use src\Presenter\FormBuilder\SpellFormBuilder;
use src\Presenter\ListPresenter\SpellListPresenter;
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
                $this->readerFactory->classe(),
                $this->readerFactory->reference(),
                new WpPostService()
            )
        );
    }
}
