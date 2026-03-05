<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Table;
use src\Domain\Criteria\LanguageCriteria;
use src\Domain\Entity\Language as L;

class LanguageRepository extends Repository implements LanguageRepositoryInterface
{
    public const TABLE = Table::LANGUAGE;

    public function getEntityClass(): string
    {
        return Language::class;
    }

    /**
     * @return ?Language
     * @SuppressWarnings("php:S1185")
     */
    public function find(int $id): ?Language
    {
        return parent::find($id);
    }

    /**
     * @return Collection<Language>
     */
    public function findAllWithCriteria(LanguageCriteria $criteria): Collection
    {
        return $this->findAllByCriteria($criteria);
    }

}
