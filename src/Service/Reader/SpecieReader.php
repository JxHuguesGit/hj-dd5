<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Constant\Constant;
use src\Constant\Field;
use src\Domain\Criteria\SpeciesCriteria;
use src\Domain\Specie as DomainSpecie;
use src\Repository\SpeciesRepositoryInterface;

final class SpecieReader
{
    public function __construct(
        private SpeciesRepositoryInterface $speciesRepository,
    ) {}

    public function speciesById(int $id): ?DomainSpecie
    {
        return $this->speciesRepository->find($id);
    }

    /**
     * @return Collection<DomainSpecie>
     */
    public function allSpecies(array $order=[Field::NAME=>Constant::CST_ASC]): Collection
    {
        return $this->speciesRepository->findAll($order);
    }

    public function speciesBySlug(string $slug): ?DomainSpecie
    {
        $species = $this->speciesRepository->findBy([Field::SLUG=>$slug]);
        return $species->first() ?? null;
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
        // Critère pour l'origine précédente (nom < courant)
        $prevCriteria = new SpeciesCriteria();
        $prevCriteria->nameLt = $species->name;

        $prev = $this->speciesRepository
            ->findAllWithCriteria($prevCriteria, [Field::NAME => Constant::CST_DESC])
            ->first();

        $nextCriteria = new SpeciesCriteria();
        $nextCriteria->nameGt = $species->name;

        $next = $this->speciesRepository
            ->findAllWithCriteria($nextCriteria, [Field::NAME => Constant::CST_ASC])
            ->first();

        return [
            'prev' => $prev ?: null,
            'next' => $next ?: null,
        ];
    }
}
