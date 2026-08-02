<?php
namespace src\Service\Domain;

use src\Collection\Collection;
use src\Domain\Entity\Power;
use src\Domain\Entity\Specie;
use src\Presenter\ViewModel\AbilityOptionView;
use src\Presenter\ViewModel\AbilityView;
use src\Service\Reader\PowerReader;
use src\Service\Reader\SpeciePowerReader;
use src\Service\Reader\SpecieReader;

final class SpecieService
{
    /** @var array<int, Power> */
    private array $powerCache = [];

    public function __construct(
        private SpeciePowerReader $speciePowerReader,
        private PowerReader $powerReader,
        private SpecieReader $specieReader,
    ) {}

    public function getAbilities(Specie $specie): Collection
    {
        $speciePowers = $this->speciePowerReader->speciePowerBySpecie($specie->id);

        $collection = new Collection();

        foreach ($speciePowers as $speciePower) {
            $power = $this->powerCache[$speciePower->powerId]
                ??= $this->powerReader->powerById($speciePower->powerId);

            if ($power === null) {
                continue;
            }

            $collection->add(
                $this->buildAbilityView($power)
            );
        }

        return $collection;
    }

    private function buildAbilityView(Power $power): AbilityView
    {
        $children = [];
        $options = [];

        foreach ($this->powerReader->powersByParentId($power->id) as $childPower) {

            $speciePowers = $this->speciePowerReader->speciePowerByPower($childPower->id);
            if ($speciePowers->isEmpty()) {
                $children[] = $this->buildAbilityView($childPower);
                continue;
            }

            foreach ($speciePowers as $speciePower) {

                $specie = $this->specieReader->speciesById($speciePower->speciesId);

                if ($specie === null) {
                    continue;
                }

                $options[$specie->id] ??= new AbilityOptionView(
                    name: $specie->name,
                    abilities: [],
                );

                $options[$specie->id]->abilities[] =
                    $this->buildAbilityView($childPower);
            }
        }

        return new AbilityView(
            id: $power->id,
            name: $power->name,
            description: $power->description,
            children: $children,
            options: $options,
        );
    }

}
