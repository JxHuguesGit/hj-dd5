<?php
namespace src\Service\Ajax;

use src\Constant\Field;
use src\Constant\Template;
use src\Domain\Criteria\MonsterCriteria;
use src\Factory\ReaderFactory;
use src\Presenter\Detail\MonsterDetailPresenter;
use src\Presenter\ListPresenter\MonsterListPresenter;
use src\Presenter\TableBuilder\MonsterTableBuilder;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Renderer\TemplateRenderer;
use src\Repository\MonsterRepository;
use src\Repository\MonsterSubTypeRepository;
use src\Repository\MonsterTypeRepository;
use src\Service\Formatter\MonsterFormatter;
use src\Service\Reader\MonsterReader;
use src\Service\Reader\MonsterSubTypeReader;
use src\Service\Reader\MonsterTypeReader;
use src\Utils\Session;

class MonsterAjax
{
    public function __construct(
        private ReaderFactory $reader
    ) {}

    public function loadMoreMonsters(): array
    {
        $reader    = $this->reader->monster();
        $presenter = new MonsterListPresenter(
            new MonsterFormatter(
                $this->reader->monsterType(),
                $this->reader->monsterSubType()
            ),
            $this->reader->reference()
        );
        $builder = new MonsterTableBuilder();

        parse_str(html_entity_decode(Session::fromPost('spellMonster')), $fromPost);
        $criteria = MonsterCriteria::fromRequest([
            'page' => Session::fromPost('page', 1),
            'type' => Session::fromPost('type'),
            ...$fromPost,
        ]);

        $result   = $reader->allMonsters($criteria);
        $viewData = $presenter->present($result);
        $objTable = $builder->build($viewData);

        return [
            'html'    => $objTable->display(),
            'hasMore' => true, //$result->hasMore()
        ];
    }

    public static function loadModal(): array
    {
        $qb     = new QueryBuilder();
        $qe     = new QueryExecutor();
        $reader = new MonsterReader(
            new MonsterRepository($qb, $qe),
        );
        $ukTag   = Session::fromPost(strtolower(Field::UKTAG), -1);
        $monster = $reader->monsterByUkTag($ukTag);
        if (! $monster) {
            return [
                'html' => 'Erreur à mettre en forme pour faire joli.',
            ];
        }

        $presenter = new MonsterDetailPresenter(
            new MonsterFormatter(
                new MonsterTypeReader(new MonsterTypeRepository($qb, $qe)),
                new MonsterSubTypeReader(new MonsterSubTypeRepository($qb, $qe)),
            ),
            $monster
        );
        $templateRenderer = new TemplateRenderer();
        return [
            'html' => $templateRenderer->render(Template::MONSTER_CARD, $presenter->present()),
        ];
    }

}
