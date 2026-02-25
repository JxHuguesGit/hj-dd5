<?php
namespace src\Service\Domain;

use src\Collection\Collection;
use src\Domain\Entity\Specie;
use src\Service\Reader\PowerReader;
use src\Service\Reader\SpeciePowerReader;

final class SpecieService
{
    /** @var array<int, Power> */
    private array $powerCache = [];

    public function __construct(
        private SpeciePowerReader $speciePowerReader,
        private PowerReader $powerReader,
    ) {}

    public function getAbilities(Specie $specie): Collection
    {
        $speciePowers = $this->speciePowerReader->specialPowerBySpecie($specie->id);

        $collection = new Collection();
        foreach ($speciePowers as $speciePower) {
            $powerId = $speciePower->powerId;
            $power   = $this->powerReader->powerById($powerId);
            $this->powerCache[$powerId] ??= $power;
            $collection->add($this->powerCache[$powerId]);
        }
        return $collection;
    }
}
