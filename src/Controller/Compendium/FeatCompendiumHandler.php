<?php
namespace src\Controller\Compendium;

use src\Constant\Constant;
use src\Constant\Field;
use src\Page\PageForm;
use src\Page\PageList;
use src\Presenter\FormBuilder\FeatFormBuilder;
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
use src\Utils\Session;

class FeatCompendiumHandler implements CompendiumHandlerInterface
{
    public function render(): string
    {
        $action = Session::fromGet(Constant::CST_ACTION);
        $slug   = Session::fromGet(Constant::CST_SLUG);

        if ($action === Constant::EDIT && $slug !== '') {
            return $this->renderEdit($slug);
        }

        return $this->renderList();
    }

    private function renderEdit(string $slug): string
    {
        $qb = new QueryBuilder();
        $qe = new QueryExecutor();
        $repository = new FeatRepository($qb, $qe);
        $reader = new FeatReader($repository);
        
        $feat = $reader->featBySlug($slug);
        // méthode à ajouter dans FeatReader
        $page = new PageForm(
            new TemplateRenderer(),
            new FeatFormBuilder(
                new WpPostService()
            )
        );
        
        return $page->renderAdmin('', $feat);
    }

    private function renderList(): string
    {
        $qb = new QueryBuilder();
        $qe = new QueryExecutor();
        $originRepo = new OriginRepository($qb, $qe);
        $repository = new FeatRepository($qb, $qe);
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
            new FeatTableBuilder(true)
        );

        return $page->renderAdmin('', $presentContent);
    }
}

