<?php
namespace src\Service\Reader;

use src\Domain\Criteria\InitiativeTrackerCriteria;
use src\Domain\Entity\InitiativeTracker;
use src\Repository\InitiativeTrackerRepositoryInterface;

final class InitiativeTrackerReader
{
    public function __construct(
        private InitiativeTrackerRepositoryInterface $repository,
    ) {}

    /**
     * @return ?InitiativeTracker
     */
    public function initiativeTrackerById(int $id): ?InitiativeTracker
    {
        return $this->repository->find($id);
    }

    /**
     * @return ?InitiativeTracker
     */
    public function initiativeTrackerByCode(string $itCode): ?InitiativeTracker
    {
        $criteria = new InitiativeTrackerCriteria();
        $criteria->iTCode = $itCode;
        return $this->repository->findAllWithCriteria($criteria)?->first();
    }

}
