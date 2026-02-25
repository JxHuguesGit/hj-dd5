<?php
namespace src\Factory\Compendium;

use src\Controller\Compendium\OriginCompendiumHandler;
use src\Presenter\ListPresenter\OriginListPresenter;
use src\Presenter\TableBuilder\OriginTableBuilder;
use src\Repository\AbilityRepository;
use src\Repository\FeatRepository;
use src\Repository\ItemRepository;
use src\Repository\OriginAbilityRepository;
use src\Repository\OriginItemRepository;
use src\Repository\OriginRepository;
use src\Repository\OriginSkillRepository;
use src\Repository\SkillRepository;
use src\Repository\ToolRepository;
use src\Service\Domain\OriginService;
use src\Service\Reader\AbilityReader;
use src\Service\Reader\FeatReader;
use src\Service\Reader\ItemReader;
use src\Service\Reader\OriginAbilityReader;
use src\Service\Reader\OriginItemReader;
use src\Service\Reader\OriginReader;
use src\Service\Reader\OriginSkillReader;
use src\Service\Reader\SkillReader;
use src\Service\Reader\ToolReader;

class OriginCompendiumFactory extends AbstractCompendiumFactory
{
    public function create(): OriginCompendiumHandler
    {
        return new OriginCompendiumHandler(
            $this->reader(OriginReader::class, OriginRepository::class),
            new OriginListPresenter(
                new OriginService(
                    $this->reader(FeatReader::class, FeatRepository::class),
                    $this->reader(ToolReader::class, ToolRepository::class),
                    $this->reader(OriginSkillReader::class, OriginSkillRepository::class),
                    $this->reader(OriginAbilityReader::class, OriginAbilityRepository::class),
                    $this->reader(OriginItemReader::class, OriginItemRepository::class),
                    $this->reader(SkillReader::class, SkillRepository::class),
                    $this->reader(AbilityReader::class, AbilityRepository::class),
                    $this->reader(ItemReader::class, ItemRepository::class),
                )
            ),
            $this->page(new OriginTableBuilder()),
        );
    }
}
