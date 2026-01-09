<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Constant\Constant;
use src\Constant\Field;
use src\Domain\Specie as DomainSpecie;
use src\Exception\NotFoundException;
use src\Repository\Species as RepositorySpecies;

final class SpecieReader
{
    public function __construct(
        private RepositorySpecies $speciesRepository,
    ) {}

    public function getSpecies(int $id): ?DomainSpecie
    {
        return $this->speciesRepository->find($id);
    }

    public function getAllSpecies(array $order=[Field::NAME=>Constant::CST_ASC]): Collection
    {
        return $this->speciesRepository->findAll($order);
    }

    public function getSpeciesBySlug(string $slug): ?DomainSpecie
    {
        $feat = $this->speciesRepository->findBy([Field::SLUG=>$slug]);
        return $feat?->first() ?? null;
    }

    public function getSpeciesBySlugOrFail(string $slug): ?DomainSpecie
    {
        $species = $this->getSpeciesBySlug($slug);
        if (!$species) {
            throw new NotFoundException("Espèce introuvable : $slug");
        }
        return $species;
    }

    public function getSpeciesByParent(int $parentId, array $order=[Field::NAME=>Constant::CST_ASC]): Collection
    {
        return $this->speciesRepository->findBy([Field::PARENTID=>$parentId], $order);
    }

    public function getPreviousAndNext(DomainSpecie $species): array
    {
        // Don précédent (ordre alphabétique)
        $prev = $this->speciesRepository->findByComplex(
            [
                [
                    'field'   => Field::NAME,
                    'operand' => '<',
                    'value'   => $species->name,
                ],
                [
                    'field'   => Field::PARENTID,
                    'operand' => '=',
                    'value'   => $species->parentId,
                ],
            ],
            [Field::NAME => Constant::CST_DESC],
            1
        )->first();

        // Don suivant
        $next = $this->speciesRepository->findByComplex(
            [
                [
                    'field'   => Field::NAME,
                    'operand' => '>',
                    'value'   => $species->name,
                ],
                [
                    'field'   => Field::PARENTID,
                    'operand' => '=',
                    'value'   => $species->parentId,
                ],
            ],
            [Field::NAME => Constant::CST_ASC],
            1
        )->first();

        return [
            'prev' => $prev ?: null,
            'next' => $next ?: null,
        ];
    }
}
