<?php
namespace src\Repository;

use src\Domain\Entity\Token;
use src\Collection\Collection;
use src\Domain\Criteria\TokenCriteria;

interface TokenRepositoryInterface
{
    /**
    * @return ?Token
    */
    public function find(int $id): ?Token;

    /**
     * @return Collection<Token>
     */
    public function findAllWithCriteria(TokenCriteria $criteria): Collection;
}
