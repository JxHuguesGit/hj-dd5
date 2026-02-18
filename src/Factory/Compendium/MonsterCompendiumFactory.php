<?php
namespace src\Factory\Compendium;

use src\Controller\Compendium\MonsterCompendiumHandler;
use src\Presenter\ListPresenter\MonsterListPresenter;
use src\Presenter\TableBuilder\MonsterTableBuilder;
use src\Repository\{MonsterRepository, MonsterSubTypeRepository, MonsterTypeRepository,  ReferenceRepository};
use src\Service\Formatter\MonsterFormatter;
use src\Service\Reader\{MonsterReader, MonsterSubTypeReader, MonsterTypeReader,  ReferenceReader};

class MonsterCompendiumFactory extends AbstractCompendiumFactory
{
    public function create(): MonsterCompendiumHandler
    {
        return new MonsterCompendiumHandler(
            $this->reader(MonsterReader::class, MonsterRepository::class),
            new MonsterListPresenter(
                new MonsterFormatter(
                    $this->reader(MonsterTypeReader::class, MonsterTypeRepository::class),
                    $this->reader(MonsterSubTypeReader::class, MonsterSubTypeRepository::class),
                ),
                $this->reader(ReferenceReader::class, ReferenceRepository::class)
            ),
            $this->page(new MonsterTableBuilder()),
            $this->renderer
        );
    }
}
