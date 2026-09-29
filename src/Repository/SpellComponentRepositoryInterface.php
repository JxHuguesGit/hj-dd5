<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Domain\Criteria\SpellComponentCriteria;
use src\Domain\Entity\SpellComponent;

interface SpellComponentRepositoryInterface
{
    /**
     * @return ?SpellComponent
     */
    public function find(int $id): ?SpellComponent;

    /**
     * @return Collection<SpellComponent>
     */
    public function findAllWithCriteria(SpellComponentCriteria $criteria): Collection;
}
