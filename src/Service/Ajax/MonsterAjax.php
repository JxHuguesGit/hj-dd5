<?php
namespace src\Service\Ajax;

use src\Constant\Field;
use src\Constant\Template;
use src\Domain\Criteria\MonsterCriteria;
use src\Factory\ReaderFactory;
use src\Factory\ServiceFactory;
use src\Presenter\Detail\MonsterDetailPresenter;
use src\Presenter\ListPresenter\MonsterListPresenter;
use src\Presenter\TableBuilder\MonsterTableBuilder;
use src\Renderer\TemplateRenderer;
use src\Service\Formatter\MonsterFormatter;
use src\Utils\Session;

class MonsterAjax
{
    public function __construct(
        private ReaderFactory $reader,
        private ServiceFactory $service,
        private TemplateRenderer $renderer
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

        parse_str(html_entity_decode(Session::fromPost('monsterFilter')), $fromPost);
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

    public function loadModal(): array
    {
        $reader  = $this->reader->monster();
        $ukTag   = Session::fromPost(strtolower(Field::UKTAG), -1);
        $monster = $reader->monsterByUkTag($ukTag);
        if (! $monster) {
            return [
                'html' => 'Erreur à mettre en forme pour faire joli.',
            ];
        }

        $presenter = new MonsterDetailPresenter(
            new MonsterFormatter(
                $this->reader->monsterType(),
                $this->reader->monsterSubType()
            ),
            $monster
        );
        return [
            'html' => $this->renderer->render(Template::MONSTER_CARD, $presenter->present()),
        ];
    }

}
