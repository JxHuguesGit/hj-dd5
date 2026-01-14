<?php
namespace src\Service;

use src\Constant\Field;
use src\Collection\Collection;
use src\Domain\Power as DomainPower;
use src\Domain\Specie as DomainSpecie;
use src\Repository\SpeciePower as RepositorySpeciePower;
use src\Service\Reader\PowerReader;

final class SpecieService
{
    /** @var array<int, DomainPower> */
    private array $powerCache = [];
    
    public function __construct(
        private RepositorySpeciePower $speciePowerRepository,
        private PowerReader $powerReader,
    ) {}


    public function getAbilities(DomainSpecie $specie): Collection
    {
        $speciePowers = $this->speciePowerRepository->findBy([
            Field::SPECIESID => $specie->id
        ]);

        $collection = new Collection();
        foreach ($speciePowers as $speciePower) {
            $powerId = $speciePower->powerId;
            $power = $this->powerReader->getPower($powerId);
            $this->powerCache[$powerId] ??= $power;
            $collection->addItem($this->powerCache[$powerId]);
        }
        return $collection;
    }
}
