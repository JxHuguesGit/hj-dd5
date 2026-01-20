<?php
namespace src\Action;

use src\Presenter\ListPresenter\SpellListPresenter;
use src\Presenter\TableBuilder\SpellTableBuilder;
use src\Service\SpellService;
use src\Service\WpPostService;
use src\Utils\Session;

class LoadMoreSpells
{
    public static function build(): string
    {
        $spellListePresenter = new SpellListPresenter();
        $spellService = new SpellService(
            new WpPostService()
        );

        $page = Session::fromPost('page', 1);
        $criteria = [
            'paged' => $page
        ];

        $spells = $spellService->allSpells($criteria);
        $viewData = $spellListePresenter->present($spells);

        $spellTableBuilder = new SpellTableBuilder();
        $objTable = $spellTableBuilder->build($viewData);
        return $objTable->display();
    }

}
