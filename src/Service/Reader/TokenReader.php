<?php
namespace src\Service\Reader;


use src\Collection\Collection;
use src\Domain\Criteria\TokenCriteria;
use src\Domain\Entity\Token;
use src\Repository\TokenRepositoryInterface;


final class TokenReader
{
    public function __construct(
        private TokenRepositoryInterface $repo,
    ) {}

    /**
     * @return ?Token
     */
    public function tokenById(int $id): ?Token
    {
        return $this->repo->find($id);
    }

    /**
     * @return Collection<Token>
     */
    public function allTokens(?TokenCriteria $criteria=null): Collection
    {
        if (!$criteria) {
            $criteria = new TokenCriteria();
        }
        return $this->repo->findAllWithCriteria($criteria);
    }

    /**
     * @return Collection<Token>
     */
    public function activeTokens(): Collection
    {
        $criteria = new TokenCriteria();
        $criteria->active = 1;
        return $this->allTokens($criteria);
    }
}
