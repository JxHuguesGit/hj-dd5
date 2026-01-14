<?php
namespace src\Repository;

use src\Domain\Item as DomainItem;
use src\Collection\Collection;

interface ItemRepositoryInterface
{
    public function find(int $id): ?DomainItem;
    /**
     * @return Collection<DomainItem>
     */
    public function findAll(array $orderBy = []): Collection;
}
