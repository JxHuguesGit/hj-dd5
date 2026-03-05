<?php
namespace src\Factory\Compendium;

use src\Controller\Compendium\OriginCompendiumHandler;
use src\Factory\ReaderFactory;
use src\Factory\RepositoryFactory;
use src\Presenter\ListPresenter\OriginListPresenter;
use src\Presenter\TableBuilder\OriginTableBuilder;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Repository\OriginRepository;
use src\Service\Domain\OriginService;
use src\Service\Reader\OriginReader;

class OriginCompendiumFactory extends AbstractCompendiumFactory
{
    public function create(): OriginCompendiumHandler
    {
        return new OriginCompendiumHandler(
            $this->reader(OriginReader::class, OriginRepository::class),
            new OriginListPresenter(
                new OriginService(
                    new ReaderFactory(new RepositoryFactory(new QueryBuilder(), new QueryExecutor()))
                )
            ),
            $this->page(new OriginTableBuilder()),
        );
    }
}
