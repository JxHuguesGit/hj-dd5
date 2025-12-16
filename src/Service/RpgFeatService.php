<?php
namespace src\Service;

use src\Collection\Collection;
use src\Domain\RpgFeat as DomainRpgFeat;
use src\Repository\RpgFeat as RepositoryRpgFeat;

final class RpgFeatService
{
    public function __construct(
        private RepositoryRpgFeat $featRepository
    ) {}
    
    public function getAllFeats(): Collection
    {
        return $this->featRepository->findAll();
    }
    
    public function getFeat(int $id): ?DomainRpgFeat
    {
        return $this->featRepository->find($id);
    }
}
