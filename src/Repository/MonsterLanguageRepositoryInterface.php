<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Domain\Criteria\MonsterLanguageCriteria;
use src\Domain\Entity\MonsterLanguage;

interface MonsterLanguageRepositoryInterface
{
    /**
     * @return Collection<MonsterLanguage>
     */
    public function findAllWithCriteria(MonsterLanguageCriteria $criteria): Collection;
}
