<?php
namespace src\Factory\Compendium;

use src\Controller\Compendium\MonsterCompendiumHandler;
use src\Factory\ReaderFactory;
use src\Factory\RepositoryFactory;
use src\Presenter\ListPresenter\MonsterListPresenter;
use src\Presenter\TableBuilder\MonsterTableBuilder;
use src\Presenter\ToastBuilder;
use src\Repository\MonsterRepository;
use src\Repository\ReferenceRepository;
use src\Service\Formatter\MonsterFormatter;
use src\Service\Reader\MonsterReader;
use src\Service\Reader\ReferenceReader;

class MonsterCompendiumFactory extends AbstractCompendiumFactory
{
    public function create(): MonsterCompendiumHandler
    {
        return new MonsterCompendiumHandler(
            $this->reader(MonsterReader::class, MonsterRepository::class),
            new MonsterListPresenter(
                new MonsterFormatter(
                    new ReaderFactory(new RepositoryFactory($this->qb, $this->qe))
                ),
                $this->reader(ReferenceReader::class, ReferenceRepository::class)
            ),
            $this->page(new MonsterTableBuilder()),
            new ToastBuilder($this->renderer),
            $this->renderer
        );
    }
}
