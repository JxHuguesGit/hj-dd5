<?php
namespace src\Service\Reader;

use src\Domain\Power as DomainPower;
use src\Repository\PowerRepositoryInterface;

final class PowerReader
{
    public function __construct(
        private PowerRepositoryInterface $powerRepository
    ) {}
    
    public function powerById(int $id): ?DomainPower
    {
        return $this->powerRepository->find($id);
    }
}
