<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Constant\Constant as C;
use src\Constant\Field as F;
use src\Domain\Criteria\ClasseCriteria;
use src\Domain\Entity\Classe;
use src\Repository\ClasseRepositoryInterface;

final class ClasseReader
{
    public function __construct(
        private ClasseRepositoryInterface $repository
    ) {}

    /**
     * @return ?Classe
     */
    public function classeById(int $id): ?Classe
    {
        return $this->repository->find($id);
    }

    /**
     * @return Collection<Classe>
     */
    public function allClasses(?ClasseCriteria $criteria=null): Collection
    {
        if (!$criteria) {
            $criteria = new ClasseCriteria();
            $criteria->orderBy = [F::NAME => C::ASC];
        }
        return $this->repository->findAllWithCriteria($criteria);
    }

    /**
     * @return Collection<Classe>
     */
    public function allSpellCastingClasses(): Collection
    {
        return $this->repository->allSpellCastingClasses();
    }
}
