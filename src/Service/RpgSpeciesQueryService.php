<?php
namespace src\Service;

use src\Collection\Collection;
use src\Constant\Constant;
use src\Constant\Field;
use src\Domain\RpgSpecies as DomainRpgSpecies;
use src\Exception\NotFoundException;
use src\Repository\RpgSpecies as RepositoryRpgSpecies;

final class RpgSpeciesQueryService
{
    public function __construct(
        private RepositoryRpgSpecies $speciesRepository,
    ) {}

    public function getSpecies(int $id): ?DomainRpgSpecies
    {
        return $this->speciesRepository->find($id);
    }
    
    public function getAllSpecies(array $order=[Field::NAME=>'ASC']): Collection
    {
        return $this->speciesRepository->findAll($order);
    }

    public function getSpeciesBySlug(string $slug): ?DomainRpgSpecies
    {
        $feat = $this->speciesRepository->findBy([Field::SLUG=>$slug]);
        return $feat?->first() ?? null;
    }

    public function getSpeciesBySlugOrFail(string $slug): ?DomainRpgSpecies
    {
        $species = $this->getSpeciesBySlug($slug);
        if (!$species) {
            throw new NotFoundException("Espèce introuvable : $slug");
        }
        return $species;
    }

    public function getSpeciesByParent(int $parentId, array $order=[Field::NAME=>'ASC']): Collection
    {
        return $this->speciesRepository->findBy([Field::PARENTID=>$parentId], $order);
    }

    public function getPreviousAndNext(DomainRpgSpecies $species): array
    {
        // Don précédent (ordre alphabétique)
        $prev = $this->speciesRepository->findByComplex(
            [
                [
                    'field'   => Field::NAME,
                    'operand' => '<',
                    'value'   => $species->name,
                ]
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
                ]
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
