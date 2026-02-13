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
use src\Repository\{MonsterRepository, MonsterSubTypeRepository, MonsterTypeRepository, ReferenceRepository};
use src\Service\Formatter\MonsterFormatter;
use src\Service\Reader\{MonsterReader, MonsterSubTypeReader, MonsterTypeReader, ReferenceReader};
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
                new MonsterTypeReader(new MonsterTypeRepository($qb, $qe)),
                new MonsterSubTypeReader(new MonsterSubTypeRepository($qb, $qe)),
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
        $monster = $reader->monsterByUkTag($ukTag);
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
