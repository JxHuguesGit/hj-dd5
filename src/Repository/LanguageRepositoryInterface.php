<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Domain\Criteria\LanguageCriteria;
use src\Domain\Entity\Language;

interface LanguageRepositoryInterface
{
    /**
     * @return ?Language
     */
    public function find(int $id): ?Language;

    /**
     * @return Collection<Language>
     */
    public function findAllWithCriteria(LanguageCriteria $criteria): Collection;
}
