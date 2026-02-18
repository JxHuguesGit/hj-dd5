<?php
namespace src\Factory\Compendium;

use src\Controller\Compendium\OriginCompendiumHandler;
use src\Presenter\ListPresenter\OriginListPresenter;
use src\Presenter\TableBuilder\OriginTableBuilder;
use src\Repository\{
    AbilityRepository,
    FeatRepository,
    ItemRepository,
    OriginAbilityRepository,
    OriginItemRepository,
    OriginRepository,
    OriginSkillRepository,
    SkillRepository,
    ToolRepository
};
use src\Service\Domain\OriginService;
use src\Service\Reader\{AbilityReader, ItemReader, OriginReader, SkillReader};

class OriginCompendiumFactory extends AbstractCompendiumFactory
{
    public function create(): OriginCompendiumHandler
    {
        return new OriginCompendiumHandler(
            $this->reader(OriginReader::class, OriginRepository::class),
            new OriginListPresenter(
                new OriginService(
                    $this->repo(FeatRepository::class),
                    $this->repo(ToolRepository::class),
                    $this->repo(OriginSkillRepository::class),
                    $this->repo(OriginAbilityRepository::class),
                    $this->repo(OriginItemRepository::class),
                    $this->reader(SkillReader::class, SkillRepository::class),
                    $this->reader(AbilityReader::class, AbilityRepository::class),
                    $this->reader(ItemReader::class, ItemRepository::class),
                )
            ),
            $this->page(new OriginTableBuilder()),
        );
    }
}
