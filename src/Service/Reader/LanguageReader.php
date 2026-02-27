<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Domain\Criteria\LanguageCriteria;
use src\Domain\Entity\Language;
use src\Repository\LanguageRepositoryInterface;

final class LanguageReader
{
    public function __construct(
        private LanguageRepositoryInterface $repository
    ) {}

    /**
     * @return ?Language
     */
    public function languageById(int $id): ?Language
    {
        return $this->repository->find($id);
    }

    /**
     * @return Collection<Language>
     */
    public function allLanguages(?LanguageCriteria $criteria = null): Collection
    {
        if (! $criteria) {
            $criteria = new LanguageCriteria();
        }
        return $this->repository->findAllWithCriteria($criteria);
    }
}
