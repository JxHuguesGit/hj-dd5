<?php
namespace src\Factory\Compendium;

use src\Controller\Compendium\SkillCompendiumHandler;
use src\Presenter\ListPresenter\SkillListPresenter;
use src\Presenter\TableBuilder\SkillTableBuilder;
use src\Repository\{OriginRepository, OriginSkillRepository, SkillRepository, SubSkillRepository};
use src\Service\Domain\SkillService;
use src\Service\Reader\{OriginReader, SkillReader};

class SkillCompendiumFactory extends AbstractCompendiumFactory
{
    public function create(): SkillCompendiumHandler
    {
        return new SkillCompendiumHandler(
            $this->reader(SkillReader::class, SkillRepository::class),
            new SkillListPresenter(
                new SkillService(
                    $this->repo(OriginSkillRepository::class),
                    $this->repo(SubSkillRepository::class),
                    $this->reader(OriginReader::class, OriginRepository::class),
                )
            ),
            $this->page(new SkillTableBuilder())
        );
    }
}
