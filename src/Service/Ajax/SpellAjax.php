<?php
namespace src\Service\Ajax;

use src\Constant\Constant as C;
use src\Domain\Criteria\SpellCriteria;
use src\Presenter\ContentBuilder\SpellCardContentBuilder;
use src\Presenter\ListPresenter\SpellListPresenter;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Repository\SpellRepository;
use src\Service\Domain\SpellService;
use src\Service\Reader\SpellReader;
use src\Utils\Session;

class SpellAjax
{
    public static function loadMoreSpells(): array
    {
        $spellService        = new SpellService(
            new SpellReader(
                new SpellRepository(
                    new QueryBuilder(),
                    new QueryExecutor()
                )
            )
        );

        parse_str(html_entity_decode(Session::fromPost(C::SPELL_FILTER)), $fromPost);
        $criteria = SpellCriteria::fromRequest($fromPost);

        $page = (int) Session::fromPost('page', 1);
        $criteria->offset = ($page - 1) * SpellCriteria::DEFAULT_PAGE_SIZE;
        $result = $spellService->allSpells($criteria);

        $spellListPresenter = new SpellListPresenter();
        $viewData = $spellListPresenter->present($result->collection);

        $spellContentBuilder = new SpellCardContentBuilder();
        $contentHtml = $spellContentBuilder->build($viewData);

        return [
            'html' => $contentHtml,
            'hasMore' => $result->hasMore,
            'nextPage' => $result->hasMore ? $page + 1 : null,
        ];
    }

}
