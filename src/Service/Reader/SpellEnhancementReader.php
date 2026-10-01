<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Constant\Constant as C;
use src\Constant\Field as F;
use src\Domain\Criteria\SpellEnhancementCriteria;
use src\Domain\Entity\SpellEnhancement;
use src\Repository\SpellEnhancementRepositoryInterface;

final class SpellEnhancementReader
{
    public function __construct(
        private SpellEnhancementRepositoryInterface $repository
    ) {}

    /**
     * @return ?SpellEnhancement
     */
    public function spellenhancementById(int $id): ?SpellEnhancement
    {
        return $this->repository->find($id);
    }

    /**
     * @return Collection<SpellEnhancement>
     */
    public function allSpellEnhancements(?SpellEnhancementCriteria $criteria=null): Collection
    {
        if (!$criteria) {
            $criteria = new SpellEnhancementCriteria();
        }
        return $this->repository->findAllWithCriteria($criteria);
    }
}
