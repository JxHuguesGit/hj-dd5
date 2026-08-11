<?php
namespace src\Service\Writer;

use src\Domain\Entity\Token;
use src\Repository\TokenRepositoryInterface;

final class TokenWriter
{
    public function __construct(
        private TokenRepositoryInterface $repository
    ) {}

    public function updatePartial(Token $token, array $changedFields): void
    {
        $this->repository->beginTransaction();
        try {
            $this->repository->updatePartial($token, $changedFields);
            $this->repository->commit();
        } catch (\Throwable $e) {
            $this->repository->rollBack();
            throw $e;
        }
    }

    public function insert(Token $mapToken): void
    {
        $this->repository->beginTransaction();
        try {
            $this->repository->insert($mapToken);
            $this->repository->commit();
        } catch (\Throwable $e) {
            $this->repository->rollBack();
            throw $e;
        }
    }

    public function delete(Token $mapToken): void
    {
        $this->repository->beginTransaction();
        try {
            $this->repository->delete($mapToken);
            $this->repository->commit();
        } catch (\Throwable $e) {
            $this->repository->rollBack();
            throw $e;
        }
    }
}
