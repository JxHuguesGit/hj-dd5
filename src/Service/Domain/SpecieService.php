<?php
namespace src\Service\Domain;

use src\Collection\Collection;
use src\Constant\Field;
use src\Domain\Entity\Specie;
use src\Repository\SpeciePowerRepositoryInterface;
use src\Service\Reader\PowerReader;

final class SpecieService
{
    /** @var array<int, Power> */
    private array $powerCache = [];

    public function __construct(
        private SpeciePowerRepositoryInterface $speciePowerRepository,
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
