<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Table;
use src\Domain\Criteria\MonsterLanguageCriteria;
use src\Domain\Entity\MonsterLanguage;

class MonsterLanguageRepository extends Repository implements MonsterLanguageRepositoryInterface
{
    public const TABLE = Table::MSTLANGUAGE;

    public function getEntityClass(): string
    {
        return MonsterLanguage::class;
    }

    /**
     * @return Collection<MonsterLanguage>
     */
    public function findAllWithCriteria(MonsterLanguageCriteria $criteria): Collection
    {
        return $this->findAllByCriteria($criteria);
    }
}
