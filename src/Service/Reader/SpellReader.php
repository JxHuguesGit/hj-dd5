<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Domain\Entity\Spell;
use src\Repository\SpellRepositoryInterface;

final class SpellReader
{
    public function __construct(
        private SpellRepositoryInterface $spellRepository
    ) {}
    
    /**
     * @return Collection<Spell>
     */
    public function allSpells(array $orderBy=[]): Collection
    {
        return $this->spellRepository->findAll($orderBy);
    }
}
