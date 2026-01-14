<?php
namespace src\Repository;

use src\Domain\Feat as DomainFeat;
use src\Collection\Collection;

interface FeatRepositoryInterface
{
    public function find(int $id): ?DomainFeat;
    public function findAll(): Collection;
    public function findBy(array $criteria, array $orderBy = []): Collection;
    public function findByComplex(array $criteriaComplex, array $orderBy = []): Collection;
}
