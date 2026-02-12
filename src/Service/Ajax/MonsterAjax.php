<?php
namespace src\Service\Ajax;

use src\Constant\Field;
use src\Constant\Template;
use src\Domain\Criteria\MonsterCriteria;
use src\Presenter\Detail\MonsterDetailPresenter;
use src\Presenter\ListPresenter\MonsterListPresenter;
use src\Presenter\TableBuilder\MonsterTableBuilder;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Renderer\TemplateRenderer;
use src\Repository\MonsterRepository;
use src\Repository\ReferenceRepository;
use src\Repository\SousTypeMonsterRepository;
use src\Repository\TypeMonsterRepository;
use src\Service\Formatter\MonsterFormatter;
use src\Service\Reader\MonsterReader;
use src\Service\Reader\ReferenceReader;
use src\Service\Reader\SousTypeMonsterReader;
use src\Service\Reader\TypeMonsterReader;
use src\Utils\Session;

class MonsterAjax
{
    public static function loadMoreMonsters(): array
    {
        $qb = new QueryBuilder();
        $qe = new QueryExecutor();
        $reader = new MonsterReader(
            new MonsterRepository($qb, $qe),
        );
        $presenter = new MonsterListPresenter(
            new MonsterFormatter(
                new TypeMonsterReader(new TypeMonsterRepository($qb, $qe)),
                new SousTypeMonsterReader(new SousTypeMonsterRepository($qb, $qe)),
            ),
            new ReferenceReader(
                new ReferenceRepository($qb, $qe)
            )
        );
        $builder = new MonsterTableBuilder();

        parse_str(html_entity_decode(Session::fromPost('spellMonster')), $fromPost);
        $criteria = MonsterCriteria::fromRequest([
            'page' => Session::fromPost('page', 1),
            'type' => Session::fromPost('type'),
            ...$fromPost
        ]);

        $result   = $reader->allMonsters($criteria);
        $viewData = $presenter->present($result/*->collection*/);
        $objTable = $builder->build($viewData);

        return [
            'html' => $objTable->display(),
            'hasMore' => true//$result->hasMore()
        ];
    }

    public static function loadModal(): array
    {
        $qb = new QueryBuilder();
        $qe = new QueryExecutor();
        $reader = new MonsterReader(
            new MonsterRepository($qb, $qe),
        );
        $ukTag = Session::fromPost(strtolower(Field::UKTAG), -1);
        $monster = $reader->originByUkTag($ukTag);
        if (!$monster) {
            return [
                'html' => 'Erreur à mettre en forme pour faire joli.',
            ];
        }

        $presenter = new MonsterDetailPresenter($monster);
        $templateRenderer = new TemplateRenderer();
        return [
            'html' => $templateRenderer->render(Template::MONSTER_CARD, $presenter->present())
        ];
    }

}
