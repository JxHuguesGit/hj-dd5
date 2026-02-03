<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Constant\Constant;
use src\Constant\Field;
use src\Domain\Criteria\SpeciesCriteria;
use src\Domain\Specie as DomainSpecie;
use src\Repository\SpeciesRepositoryInterface;
use src\Utils\Navigation;

final class SpecieReader
{
    public function __construct(
        private SpeciesRepositoryInterface $speciesRepository,
    ) {}

    public function speciesById(int $id): ?DomainSpecie
    {
        return $this->speciesRepository->find($id);
    }

    public function speciesBySlug(string $slug): ?DomainSpecie
    {
        $species = $this->speciesRepository->findBy([Field::SLUG=>$slug]);
        return $species->first() ?? null;
    }

    /**
     * @return Collection<DomainSpecie>
     */
    public function allSpecies(array $order=[Field::NAME=>Constant::CST_ASC]): Collection
    {
        return $this->speciesRepository->findAll($order);
    }

    /**
     * @return Collection<DomainSpecie>
     */
    public function speciesByParent(int $parentId, array $order=[Field::NAME=>Constant::CST_ASC]): Collection
    {
        return $this->speciesRepository->findBy([Field::PARENTID=>$parentId], $order);
    }

    public function getPreviousAndNext(DomainSpecie $species): array
    {
        return Navigation::getPrevNext(
            function (string $operand, string $order) use ($species) {
                $criteria = new SpeciesCriteria();
                $criteria->parentId = $species->parentId;
                $operand === '<'
                    ? $criteria->nameLt = $species->name
                    : $criteria->nameGt = $species->name
                ;
                return $this->speciesRepository->findAllWithCriteria($criteria, [Field::NAME => $order]);
            }
        );
    }
}
