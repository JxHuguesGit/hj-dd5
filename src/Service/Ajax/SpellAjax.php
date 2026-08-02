<?php
namespace src\Service\Ajax;

use src\Constant\Constant as C;
use src\Domain\Criteria\SpellCriteria;
use src\Presenter\ContentBuilder\SpellCardContentBuilder;
use src\Presenter\ListPresenter\SpellListPresenter;
use src\Service\Domain\SpellService;
use src\Service\Domain\WpPostService;
use src\Utils\Session;

class SpellAjax
{
    public static function loadMoreSpells(): array
    {
        $spellService        = new SpellService(new WpPostService());
        $spellListePresenter = new SpellListPresenter();
        $spellContentBuilder = new SpellCardContentBuilder();

        parse_str(html_entity_decode(Session::fromPost('spellFilter')), $fromPost);

        $criteria = SpellCriteria::fromRequest([
            'page'             => Session::fromPost('page', 1),
            C::TYPE => Session::fromPost(C::TYPE),
            ...$fromPost,
        ]);

        $result      = $spellService->allSpells($criteria->toWpQueryArgs());
        $viewData    = $spellListePresenter->present($result->collection);
        $contentHtml = $spellContentBuilder->build($viewData);

        return [
            'html'    => $contentHtml,
            'hasMore' => $result->hasMore(),
        ];
    }

}
