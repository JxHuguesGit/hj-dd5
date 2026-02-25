<?php
namespace src\Service\Domain;

use src\Collection\Collection;
use src\Domain\Entity\Feat;
use src\Domain\Entity\Origin;
use src\Domain\Entity\Tool;
use src\Service\Reader\AbilityReader;
use src\Service\Reader\FeatReader;
use src\Service\Reader\ItemReader;
use src\Service\Reader\OriginAbilityReader;
use src\Service\Reader\OriginItemReader;
use src\Service\Reader\OriginSkillReader;
use src\Service\Reader\SkillReader;
use src\Service\Reader\ToolReader;

final class OriginService
{
    /** @var array<int, Ability> */
    private array $abilityCache = [];
    /** @var array<int, Item> */
    private array $itemCache = [];
    /** @var array<int, Skill> */
    private array $skillCache = [];

    public function __construct(
        private FeatReader $featReader,
        private ToolReader $toolReader,
        private OriginSkillReader $originSkillReader,
        private OriginAbilityReader $originAbilityReader,
        private OriginItemReader $originItemReader,
        private SkillReader $skillReader,
        private AbilityReader $abilityReader,
        private ItemReader $itemReader,
    ) {}

    public function getFeat(Origin $origin): ?Feat
    {
        if ($origin->featId <= 0) {
            return null;
        }

        return $this->featReader->featById($origin->featId);
    }

    public function getTool(Origin $origin): ?Tool
    {
        if ($origin->toolId <= 0) {
            return null;
        }
        return $this->toolReader->findWithRelations($origin->toolId);
    }

    public function getSkills(Origin $origin): Collection
    {
        $originSkills = $this->originSkillReader->originSkillsByOrigin($origin->id);
        $collection   = new Collection();
        foreach ($originSkills as $originSkill) {
            $skillId = $originSkill->skillId;
            $skill   = $this->skillReader->skillById($skillId);
            $this->skillCache[$skillId] ??= $skill;
            $collection->add($this->skillCache[$skillId]);
        }
        return $collection;
    }

    public function getAbilities(Origin $origin): Collection
    {
        $originAbilities = $this->originAbilityReader->originAbilitysByOrigin($origin->id);
        $collection      = new Collection();
        foreach ($originAbilities as $originAbility) {
            $abilityId = $originAbility->abilityId;
            $ability   = $this->abilityReader->abilityById($abilityId);
            $this->abilityCache[$abilityId] ??= $ability;
            $collection->add($this->abilityCache[$abilityId]);
        }
        return $collection;
    }

    public function getItems(Origin $origin): Collection
    {
        $originItems = $this->originItemReader->originItemByOrigin($origin->id);
        $collection  = new Collection();
        foreach ($originItems as $originItem) {
            $itemId = $originItem->itemId;
            $item   = $this->itemReader->itemById($itemId);
            $this->itemCache[$itemId] ??= $item;
            if ($item !== null) {
                for ($i = 0; $i < $originItem->quantity; $i++) {
                    $collection->add($this->itemCache[$itemId]);
                }
            }
        }
        return $collection;
    }
}
