<?php
namespace src\Controller\Compendium;

use src\Constant\Constant;
use src\Constant\Field;
use src\Constant\Language;
use src\Page\PageList;
use src\Presenter\ListPresenter\FeatListPresenter;
use src\Presenter\TableBuilder\FeatTableBuilder;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Renderer\TemplateRenderer;
use src\Repository\FeatRepository;
use src\Repository\OriginRepository;
use src\Service\Domain\WpPostService;
use src\Service\Reader\FeatReader;
use src\Service\Reader\OriginReader;

class FeatCompendiumHandler implements CompendiumHandlerInterface
{
    public function render(): string
    {
        $originRepo = new OriginRepository(new QueryBuilder(), new QueryExecutor());
        $repository = new FeatRepository(new QueryBuilder(), new QueryExecutor());
        $reader = new FeatReader($repository);

        $feats = $reader->allFeats([
            Field::FEATTYPEID => Constant::CST_ASC,
            Field::NAME       => Constant::CST_ASC
        ]);

        $presenter = new FeatListPresenter(
            new OriginReader($originRepo),
            new WpPostService()
        );
        $presentContent = $presenter->present($feats);

        $page = new PageList(
            new TemplateRenderer(),
            new FeatTableBuilder()
        );

        return $page->renderAdmin(Language::LG_FEATS_TITLE, $presentContent);
    }
}

