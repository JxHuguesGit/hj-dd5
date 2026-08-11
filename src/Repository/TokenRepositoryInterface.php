<?php
namespace src\Repository;

use src\Domain\Entity\Token;
use src\Collection\Collection;
use src\Domain\Criteria\TokenCriteria;

interface TokenRepositoryInterface
{
    public function beginTransaction(): void;
    public function commit(): void;
    public function rollBack(): void;

    public function updatePartial(Token $token, array $changedFields): void;
    public function insert(Token $token): void;
    public function delete(Token $token): void;

    /**
    * @return ?Token
    */
    public function find(int $id): ?Token;

    /**
     * @return Collection<Token>
     */
    public function findAllWithCriteria(TokenCriteria $criteria): Collection;
}
