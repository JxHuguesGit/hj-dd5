<?php
namespace src\Service\Domain;

use src\Collection\Collection;
use src\Domain\Entity\Feat;
use src\Domain\Entity\Origin;
use src\Domain\Entity\Tool;
use src\Factory\ReaderFactory;

final class OriginService
{
    /** @var array<int, Ability> */
    private array $abilityCache = [];
    /** @var array<int, Item> */
    private array $itemCache = [];
    /** @var array<int, Skill> */
    private array $skillCache = [];

    public function __construct(
        private ReaderFactory $readerFactory,
    ) {}

    public function getFeat(Origin $origin): ?Feat
    {
        if ($origin->featId <= 0) {
            return null;
        }

        return $this->readerFactory->feat()->featById($origin->featId);
    }

    public function getTool(Origin $origin): ?Tool
    {
        if ($origin->toolId <= 0) {
            return null;
        }
        return $this->readerFactory->tool()->findWithRelations($origin->toolId);
    }

    public function getSkills(Origin $origin): Collection
    {
        $originSkills = $this->readerFactory->originSkill()->originSkillsByOrigin($origin->id);
        $collection   = new Collection();
        foreach ($originSkills as $originSkill) {
            $skillId = $originSkill->skillId;
            $skill   = $this->readerFactory->skill()->skillById($skillId);
            $this->skillCache[$skillId] ??= $skill;
            $collection->add($this->skillCache[$skillId]);
        }
        return $collection;
    }

    public function getAbilities(Origin $origin): Collection
    {
        $originAbilities = $this->readerFactory->originAbility()->originAbilitysByOrigin($origin->id);
        $collection      = new Collection();
        foreach ($originAbilities as $originAbility) {
            $abilityId = $originAbility->abilityId;
            $ability   = $this->readerFactory->ability()->abilityById($abilityId);
            $this->abilityCache[$abilityId] ??= $ability;
            $collection->add($this->abilityCache[$abilityId]);
        }
        return $collection;
    }

    public function getItems(Origin $origin): Collection
    {
        $originItems = $this->readerFactory->originItem()->originItemsByOrigin($origin->id);
        $collection  = new Collection();
        foreach ($originItems as $originItem) {
            $itemId = $originItem->itemId;
            $item   = $this->readerFactory->item()->itemById($itemId);
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
