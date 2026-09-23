<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Domain\Criteria\SpellCriteria;
use src\Domain\Entity\Spell;
use src\Repository\SpellRepositoryInterface;

final class SpellReader
{
    public function __construct(
        private SpellRepositoryInterface $spellRepository
    ) {}

    /**
     * @return ?Spell
     */
    public function spellByWpPostId(int $wpPostId): ?Spell
    {
        $criteria = new SpellCriteria();
        $criteria->wpPostId = $wpPostId;
        return $this->spellRepository
            ->findAllWithRelations($criteria)
            ?->first() ?? null;
    }
    
    /**
     * @return Collection<Spell>
     */
    public function allSpells(?SpellCriteria $criteria = null): Collection
    {
        if (!$criteria) {
            $criteria = new SpellCriteria();
        }

        return $this->spellRepository->findAllWithRelations($criteria);
    }

    public function spellBySlug(string $slug): ?Spell
    {
        $criteria = new SpellCriteria();
        $criteria->slug = $slug;
        $criteria->limit = 1;

        return $this->spellRepository
            ->findAllWithRelations($criteria)
            ->first();
    }

    public function classesBySpellId(int $spellId): array
    {
        $classes = $this->spellRepository->classesBySpellId($spellId);

        return $classes
            ->map(fn ($classe) => $classe->name)
            ->toArray();
    }
    
}
