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
use src\Repository\ReferenceRepository;
use src\Service\Domain\OriginService;
use src\Service\Reader\OriginReader;
use src\Service\Reader\ReferenceReader;

class OriginCompendiumFactory extends AbstractCompendiumFactory
{
    public function create(): OriginCompendiumHandler
    {
        return new OriginCompendiumHandler(
            $this->reader(OriginReader::class, OriginRepository::class),
            new OriginListPresenter(
                $this->reader(ReferenceReader::class, ReferenceRepository::class),
                new OriginService(
                    new ReaderFactory(new RepositoryFactory(new QueryBuilder(), new QueryExecutor()))
                )
            ),
            $this->page(new OriginTableBuilder()),
        );
    }
}
