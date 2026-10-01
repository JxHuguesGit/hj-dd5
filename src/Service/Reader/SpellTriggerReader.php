<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Constant\Constant as C;
use src\Constant\Field as F;
use src\Domain\Criteria\SpellTriggerCriteria;
use src\Domain\Entity\SpellTrigger;
use src\Repository\SpellTriggerRepositoryInterface;

final class SpellTriggerReader
{
    public function __construct(
        private SpellTriggerRepositoryInterface $repository
    ) {}

    /**
     * @return ?SpellTrigger
     */
    public function spelltriggerById(int $id): ?SpellTrigger
    {
        return $this->repository->find($id);
    }

    /**
     * @return Collection<SpellTrigger>
     */
    public function allSpellTriggers(?SpellTriggerCriteria $criteria=null): Collection
    {
        if (!$criteria) {
            $criteria = new SpellTriggerCriteria();
        }
        return $this->repository->findAllWithCriteria($criteria);
    }
}
