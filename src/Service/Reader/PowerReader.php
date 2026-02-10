<?php
namespace src\Service\Reader;

use src\Domain\Entity\Power;
use src\Repository\PowerRepositoryInterface;

final class PowerReader
{
    public function __construct(
        private PowerRepositoryInterface $powerRepository
    ) {}
    
    /**
     * @return ?Power
     */
    public function powerById(int $id): ?Power
    {
        return $this->powerRepository->find($id);
    }
}
