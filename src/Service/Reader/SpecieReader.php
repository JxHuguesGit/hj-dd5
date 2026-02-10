<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Constant\Constant;
use src\Constant\Field;
use src\Domain\Criteria\SpeciesCriteria;
use src\Domain\Entity\Specie;
use src\Repository\SpeciesRepositoryInterface;
use src\Utils\Navigation;

final class SpecieReader
{
    public function __construct(
        private SpeciesRepositoryInterface $speciesRepository,
    ) {}

    /**
     * @return ?Specie
     */
    public function speciesById(int $id): ?Specie
    {
        return $this->speciesRepository->find($id);
    }

    /**
     * @return ?Specie
     */
    public function speciesBySlug(string $slug): ?Specie
    {
        $criteria = new SpeciesCriteria();
        $criteria->slug = $slug;
        return $this->speciesRepository->findAllWithCriteria($criteria)?->first() ?? null;
    }

    /**
     * @return Collection<Specie>
     */
    public function allSpecies(array $order=[Field::NAME=>Constant::CST_ASC]): Collection
    {
        $criteria = new SpeciesCriteria();
        $criteria->orderBy = $order;
        return $this->speciesRepository->findAllWithCriteria($criteria);
    }

    /**
     * @return Collection<Specie>
     */
    public function speciesByParent(int $parentId, array $order=[Field::NAME=>Constant::CST_ASC]): Collection
    {
        $criteria = new SpeciesCriteria();
        $criteria->parentId = $parentId;
        $criteria->orderBy = $order;
        return $this->speciesRepository->findAllWithCriteria($criteria);
    }

    public function getPreviousAndNext(Specie $species): array
    {
        return Navigation::getPrevNext(
            function (string $operand, string $order) use ($species) {
                $criteria = new SpeciesCriteria();
                $criteria->parentId = $species->parentId;
                $operand === '&lt;'
                    ? $criteria->nameLt = $species->name
                    : $criteria->nameGt = $species->name
                ;
                $criteria->orderBy = [Field::NAME => $order];
                return $this->speciesRepository->findAllWithCriteria($criteria);
            }
        );
    }
}
