<?php
namespace src\Service\Domain;

use src\Constant\Constant as C;
use src\Domain\Criteria\SpellCriteria;
use src\Domain\Entity\Spell;
use src\Domain\Result\SpellResult;
use src\Service\Reader\SpellReader;

final class SpellService
{
    public function __construct(
        private SpellReader $spellReader,
    ) {}

    public function allSpells(?SpellCriteria $criteria = null): SpellResult
    {
        if (!$criteria) {
            $criteria = new SpellCriteria();
        }
        $criteria->limit = SpellCriteria::DEFAULT_PAGE_SIZE + 1;
        $spells = $this->spellReader->allSpells($criteria);
        $hasMore = $spells->count() > SpellCriteria::DEFAULT_PAGE_SIZE;
        if ($hasMore) {
            $spells = $spells->slice(0, SpellCriteria::DEFAULT_PAGE_SIZE);
        }

        return new SpellResult(
            collection: $spells,
            hasMore: $hasMore,
        );

    }

    public function spellBySlug(string $slug): ?Spell
    {
        $spell = $this->spellReader->spellBySlug($slug);

        if ($spell === null) {
            return null;
        }

        $spell->classes = $this->spellReader->classesBySpellId($spell->id);

        return $spell;
    }

    public function getPreviousAndNext(?Spell $spell): array
    {
        if ($spell === null) {
            return [
                C::PREV => null,
                C::NEXT => null,
            ];
        }

        $criteria = new SpellCriteria();
        $criteria->limit = -1;

        $allSpells = $this->spellReader->allSpells($criteria);

        $idx = $allSpells->findKey(
            fn(Spell $item) => $item->slug === $spell->slug
        );

        if ($idx === null) {
            return [
                C::PREV => null,
                C::NEXT => null,
            ];
        }

        $count = $allSpells->count();

        $prev = $allSpells
            ->slice(($idx - 1 + $count) % $count, 1)
            ->first();
        $prev->classes = [];

        $next = $allSpells
            ->slice(($idx + 1) % $count, 1)
            ->first();
        $next->classes = [];

        return [
            C::PREV => $prev,
            C::NEXT => $next,
        ];
    }
}
