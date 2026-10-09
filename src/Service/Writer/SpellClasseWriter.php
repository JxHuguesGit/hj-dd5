<?php
namespace src\Service\Writer;

use src\Collection\Collection;
use src\Domain\Criteria\SpellClasseCriteria;
use src\Domain\Entity\SpellClasse;
use src\Repository\SpellClasseRepositoryInterface;

class SpellClasseWriter
{
    public function __construct(
        private SpellClasseRepositoryInterface $repository
    ) {}

    public function deleteSpellClasses(Collection $spellClasses): void
    {
        foreach ($spellClasses as $spellClasse) {
            $obj = new SpellClasseCriteria();
            $obj->spellId = $spellClasse->spellId;
            $this->repository->deleteByCriteria($obj);
        }
    }

    public function insert(SpellClasse $spellClasse): void
    {
        $this->repository->beginTransaction();
        try {
            $this->repository->insert($spellClasse);
            $this->repository->commit();
        } catch (\Throwable $e) {
            $this->repository->rollBack();
            throw $e;
        }
    }

    public function replaceSpellClasses(
        int $spellId,
        array $classeIds
    ): void {
        $this->repository->beginTransaction();

        try {
            $criteria = new SpellClasseCriteria();
            $criteria->spellId = $spellId;

            $existing = $this->repository->findAllWithCriteria($criteria);

            $this->deleteSpellClasses($existing);

            foreach ($classeIds as $classeId) {
                $spellClasse = new SpellClasse();
                $spellClasse->spellId = $spellId;
                $spellClasse->classeId = (int) $classeId;

                $this->repository->insert($spellClasse);
            }

            $this->repository->commit();
        } catch (\Throwable $e) {
            $this->repository->rollBack();
            throw $e;
        }
    }
}
