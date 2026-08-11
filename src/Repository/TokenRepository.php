<?php
namespace src\Repository;


use src\Collection\Collection;
use src\Constant\Table;
use src\Domain\Criteria\TokenCriteria;
use src\Domain\Entity\Token;


class TokenRepository extends Repository implements TokenRepositoryInterface
{
    public const TABLE = Table::TOKEN;

    public function getEntityClass(): string
    {
        return Token::class;
    }

    /**
     * @return ?Token
     * @SuppressWarnings("php:S1185")
     */
    public function find(int $id): ?Token
    {
        return parent::find($id);
    }

    /**
     * @return Collection<Token>
     */
    public function findAllWithCriteria(TokenCriteria $criteria): Collection
    {
        return $this->findAllByCriteria($criteria);
    }
}
