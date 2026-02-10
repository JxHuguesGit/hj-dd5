<?php
namespace src\Service\Domain;

use src\Constant\Field;
use src\Collection\Collection;
use src\Domain\Entity\Power;
use src\Domain\Entity\Specie;
use src\Repository\SpeciePower as RepositorySpeciePower;
use src\Service\Reader\PowerReader;

final class SpecieService
{
    /** @var array<int, Power> */
    private array $powerCache = [];
    
    public function __construct(
        private RepositorySpeciePower $speciePowerRepository,
        private PowerReader $powerReader,
    ) {}


    public function getAbilities(Specie $specie): Collection
    {
        $speciePowers = $this->speciePowerRepository->findBy([
            Field::SPECIESID => $specie->id
        ]);

        $collection = new Collection();
        foreach ($speciePowers as $speciePower) {
            $powerId = $speciePower->powerId;
            $power = $this->powerReader->powerById($powerId);
            $this->powerCache[$powerId] ??= $power;
            $collection->add($this->powerCache[$powerId]);
        }
        return $collection;
    }
}
