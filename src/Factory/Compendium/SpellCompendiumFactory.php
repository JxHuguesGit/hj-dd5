<?php
namespace src\Factory\Compendium;

use src\Controller\Compendium\SpellCompendiumHandler;
use src\Presenter\ListPresenter\SpellListPresenter;
use src\Presenter\Modal\SpellFilterModalPresenter;
use src\Presenter\TableBuilder\SpellTableBuilder;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Renderer\TemplateRenderer;
use src\Repository\ReferenceRepository;
use src\Service\Domain\SpellService;
use src\Service\Domain\WpPostService;
use src\Service\Reader\ReferenceReader;

class SpellCompendiumFactory extends AbstractCompendiumFactory
{
    public function create(): SpellCompendiumHandler
    {
        $referenceReader = new ReferenceReader(
            new ReferenceRepository(
                new QueryBuilder(),
                new QueryExecutor(),
            )
        );
       return new SpellCompendiumHandler(
            new SpellService(new WpPostService()),
            new SpellListPresenter(
                $referenceReader
            ),
            $this->page(new SpellTableBuilder()),
            new SpellFilterModalPresenter(
                $referenceReader,
                new TemplateRenderer()
            )
        );
    }
}
