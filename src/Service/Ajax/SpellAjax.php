<?php
namespace src\Service\Ajax;

use src\Domain\Criteria\SpellCriteria;
use src\Presenter\ListPresenter\SpellListPresenter;
use src\Presenter\TableBuilder\SpellTableBuilder;
use src\Service\Domain\SpellService;
use src\Service\Domain\WpPostService;
use src\Utils\Session;

class SpellAjax
{
    public static function loadMoreSpells(): array
    {
        $spellService = new SpellService(new WpPostService());
        $spellListePresenter = new SpellListPresenter();
        $spellTableBuilder = new SpellTableBuilder();

        parse_str(html_entity_decode(Session::fromPost('spellFilter')), $fromPost);

        $criteria = SpellCriteria::fromRequest([
            'page' => Session::fromPost('page', 1),
            'type' => Session::fromPost('type'),
            ...$fromPost
        ]);

        $result   = $spellService->allSpells($criteria->toWpQueryArgs());
        $viewData = $spellListePresenter->present($result->getCollection());
        $objTable = $spellTableBuilder->build($viewData);

        return [
            'html' => $objTable->display(),
            'hasMore' => $result->hasMore()
        ];
    }

}
