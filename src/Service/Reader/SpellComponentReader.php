<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Constant\Constant as C;
use src\Constant\Field as F;
use src\Domain\Criteria\SpellComponentCriteria;
use src\Domain\Entity\SpellComponent;
use src\Repository\SpellComponentRepositoryInterface;

final class SpellComponentReader
{
    public function __construct(
        private SpellComponentRepositoryInterface $repository
    ) {}

    /**
     * @return ?SpellComponent
     */
    public function spellcomponentById(int $id): ?SpellComponent
    {
        return $this->repository->find($id);
    }

    /**
     * @return Collection<SpellComponent>
     */
    public function allSpellComponents(?SpellComponentCriteria $criteria=null): Collection
    {
        if (!$criteria) {
            $criteria = new SpellComponentCriteria();
        }
        return $this->repository->findAllWithCriteria($criteria);
    }
}
