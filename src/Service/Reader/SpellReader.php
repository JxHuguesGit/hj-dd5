<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Domain\Spell as DomainSpell;
use src\Repository\SpellRepositoryInterface;
use src\Service\WpPostService;

final class SpellReader
{
    public function __construct(
        private SpellRepositoryInterface $spellRepository
    ) {}
    
    /**
     * @return Collection<DomainSpell>
     */
    public function allSpells(array $orderBy=[]): Collection
    {
        return $this->spellRepository->findAll($orderBy);
    }
    
    public function spellById(int $id): ?DomainSpell
    {
        return $this->spellRepository->find($id);
    }
}
