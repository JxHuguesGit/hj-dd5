<?php
namespace src\Service\Ajax;

use src\Collection\Collection;
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

        $view = Session::fromPost(C::VIEW, 'grid');
        $contentHtml = match ($view) {
            'table' => static::buildTable($result->collection),
            default => static::buildGrid($result->collection),
        };

        return [
            'html' => $contentHtml,
            'hasMore' => $result->hasMore,
            'nextPage' => $result->hasMore ? $page + 1 : null,
        ];
    }

    public static function buildGrid(Collection $spells): string
    {
        $spellListPresenter = new SpellListPresenter();
        $viewData = $spellListPresenter->present($spells);

        $spellContentBuilder = new SpellCardContentBuilder();
        return $spellContentBuilder->build($viewData);
    }

    public static function buildTable(Collection $spells): string
    {
        return '<tr><td colspan="8">Wip Admin</td></tr>';
    }

}
