<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Domain\Criteria\ITCharacterCriteria;
use src\Domain\Entity\ITCharacter;
use src\Repository\InitTrackCharacterRepositoryInterface;

final class InitTrackCharacterReader
{
    public function __construct(
        private InitTrackCharacterRepositoryInterface $repository,
    ) {}

    /**
     * @return ?ITCharacter
     */
    public function itCharacterById(int $id): ?ITCharacter
    {
        return $this->repository->find($id);
    }

    /**
     * @return Collection<ITCharacter>
     */
    public function charactersByCode(string $itCode, ?ITCharacterCriteria $criteria = null): ?Collection
    {
        if (null==$criteria) {
            $criteria = new ITCharacterCriteria();
            $criteria->initiativeTrackerId = $itCode;
        }
        return $this->repository->findAllWithCriteria($criteria);
    }

    /**
     * @return Collection<ITCharacter>
     */
    public function allItCharacters(ITCharacterCriteria $criteria): ?Collection
    {
        return $this->repository->findAllWithCriteria($criteria);
    }

}
