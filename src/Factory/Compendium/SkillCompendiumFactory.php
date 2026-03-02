<?php
namespace src\Factory\Compendium;

use src\Controller\Compendium\SkillCompendiumHandler;
use src\Presenter\ListPresenter\SkillListPresenter;
use src\Presenter\TableBuilder\SkillTableBuilder;
use src\Repository\OriginRepository;
use src\Repository\OriginSkillRepository;
use src\Repository\SkillRepository;
use src\Repository\SubSkillRepository;
use src\Service\Domain\SkillService;
use src\Service\Reader\OriginReader;
use src\Service\Reader\OriginSkillReader;
use src\Service\Reader\SkillReader;
use src\Service\Reader\SubSkillReader;

class SkillCompendiumFactory extends AbstractCompendiumFactory
{
    public function create(): SkillCompendiumHandler
    {
        return new SkillCompendiumHandler(
            $this->reader(SkillReader::class, SkillRepository::class),
            new SkillListPresenter(
                new SkillService(
                    $this->reader(OriginSkillReader::class, OriginSkillRepository::class),
                    $this->reader(SubSkillReader::class, SubSkillRepository::class),
                    $this->reader(OriginReader::class, OriginRepository::class),
                )
            ),
            $this->page(new SkillTableBuilder())
        );
    }
}
