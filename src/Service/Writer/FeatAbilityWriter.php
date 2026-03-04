<?php
namespace src\Service\Writer;

use src\Collection\Collection;
use src\Domain\Entity\FeatAbility;
use src\Repository\FeatAbilityRepositoryInterface;

class FeatAbilityWriter
{
    public function __construct(
        private FeatAbilityRepositoryInterface $repository
    ) {}

    public function deleteFeatAbilities(Collection $featAbilities): void
    {
        foreach ($featAbilities as $featAbility) {
            $this->repository->delete($featAbility);
        }
    }

    public function insert(FeatAbility $featAbility): void
    {
        //$this->repository->beginTransaction();
        try {
            $this->repository->insert($featAbility);
            //$this->repository->commit();
        } catch (\Throwable $e) {
            //$this->repository->rollBack();
            throw $e;
        }
    }
}
