<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Domain\Criteria\MonsterLanguageCriteria;
use src\Domain\Entity\MonsterLanguage;
use src\Repository\MonsterLanguageRepositoryInterface;

final class MonsterLanguageReader
{
    public function __construct(
        private MonsterLanguageRepositoryInterface $repository,
    ) {}

    /**
     * @return ?MonsterLanguage
     */
    public function monsterLanguageById(int $id): ?MonsterLanguage
    {
        return $this->repository->find($id);
    }

    public function monsterLanguagesByMonsterId(int $id): Collection
    {
        $criteria            = new MonsterLanguageCriteria();
        $criteria->monsterId = $id;
        return $this->repository->findAllWithCriteria($criteria);
    }

    /**
     * @return Collection<MonsterLanguage>
     */
    public function allMonsterLanguages(?MonsterLanguageCriteria $criteria = null): Collection
    {
        if (! $criteria) {
            $criteria = new MonsterLanguageCriteria();
        }
        return $this->repository->findAllWithCriteria($criteria);
    }
}
