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
     * @return Collection<ITCharacter>
     */
    public function charactersByCode(string $itCode): ?Collection
    {
        $criteria = new ITCharacterCriteria();
        $criteria->initiativeTrackerId = $itCode;
        return $this->repository->findAllWithCriteria($criteria);
    }

}
