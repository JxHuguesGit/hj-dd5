<?php
namespace src\Service\Domain;

use src\Constant\Field;
use src\Collection\Collection;
use src\Domain\Ability as DomainAbility;
use src\Domain\Feat as DomainFeat;
use src\Domain\Item as DomainItem;
use src\Domain\Origin as DomainOrigin;
use src\Domain\Skill as DomainSkill;
use src\Domain\Tool as DomainTool;
use src\Repository\FeatRepository;
use src\Repository\OriginAbility as RepositoryOriginAbility;
use src\Repository\OriginItem as RepositoryOriginItem;
use src\Repository\OriginSkill as RepositoryOriginSkill;
use src\Repository\ToolRepository;
use src\Service\Reader\AbilityReader;
use src\Service\Reader\ItemReader;
use src\Service\Reader\SkillReader;

final class OriginService
{
    /** @var array<int, DomainAbility> */
    private array $abilityCache = [];
    /** @var array<int, DomainItem> */
    private array $itemCache = [];
    /** @var array<int, DomainSkill> */
    private array $skillCache = [];
    
    public function __construct(
        private FeatRepository $featRepository,
        private ToolRepository $toolRepository,
        private RepositoryOriginSkill $originSkillRepository,
        private RepositoryOriginAbility $originAbilityRepository,
        private RepositoryOriginItem $originItemRepository,
        private SkillReader $skillReader,
        private AbilityReader $abilityReader,
        private ItemReader $itemReader,
    ) {}
    
    public function getFeat(DomainOrigin $origin): ?DomainFeat
    {
        if ($origin->featId <= 0) {
            return null;
        }

        return $this->featRepository->find($origin->featId);
    }

    public function getTool(DomainOrigin $origin): ?DomainTool
    {
        if ($origin->toolId <= 0) {
            return null;
        }

        return $this->toolRepository->find($origin->toolId);
    }

    public function getSkills(DomainOrigin $origin): Collection
    {
        $originSkills = $this->originSkillRepository->findBy([
            Field::ORIGINID => $origin->id
        ]);

        $collection = new Collection();
        foreach ($originSkills as $originSkill) {
            $skillId = $originSkill->skillId;
            $skill = $this->skillReader->skillById($skillId);
            $this->skillCache[$skillId] ??= $skill;
            $collection->add($this->skillCache[$skillId]);
        }
        return $collection;
    }

    public function getAbilities(DomainOrigin $origin): Collection
    {
        $originAbilities = $this->originAbilityRepository->findBy([
            Field::ORIGINID => $origin->id
        ]);

        $collection = new Collection();
        foreach ($originAbilities as $originAbility) {
            $abilityId = $originAbility->abilityId;
            $ability = $this->abilityReader->abilityById($abilityId);
            $this->abilityCache[$abilityId] ??= $ability;
            $collection->add($this->abilityCache[$abilityId]);
        }
        return $collection;
    }

    public function getItems(DomainOrigin $origin): Collection
    {
        $originItems = $this->originItemRepository->findBy([
            Field::ORIGINID => $origin->id
        ]);

        $collection = new Collection();
        foreach ($originItems as $originItem) {
            $itemId = $originItem->itemId;
            $item = $this->itemReader->itemById($itemId);
            $this->itemCache[$itemId] ??= $item;
            if ($item!==null) {
                for ($i=0; $i<$originItem->quantity; $i++) {
                    $collection->add($this->itemCache[$itemId]);
                }
            }
        }
        return $collection;
    }
}
