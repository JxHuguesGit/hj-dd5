<?php
namespace src\Service\Ajax;

use src\Presenter\ListPresenter\SpellListPresenter;
use src\Presenter\TableBuilder\SpellTableBuilder;
use src\Service\Domain\SpellService;
use src\Service\Domain\WpPostService;
use src\Utils\Session;

class SpellAjax
{
    public static function loadMoreSpells(): string
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
