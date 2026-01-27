<?php
namespace src\Controller\Compendium;

use src\Constant\Language;
use src\Page\PageList;
use src\Presenter\ListPresenter\SpellListPresenter;
use src\Presenter\TableBuilder\SpellTableBuilder;
use src\Renderer\TemplateRenderer;
use src\Service\Domain\SpellService;
use src\Service\Domain\WpPostService;

class SpellCompendiumHandler implements CompendiumHandlerInterface
{
    public function render(): string
    {
        $reader = new SpellService(
            new WpPostService()
        );

        $spells = ($reader->allSpells())->collection;

        $presenter = new SpellListPresenter();
        $presentContent = $presenter->present($spells);

        $page = new PageList(
            new TemplateRenderer(),
            new SpellTableBuilder()
        );
        return $page->renderAdmin(Language::LG_SPELLS_TITLE, $presentContent);
    }
}
