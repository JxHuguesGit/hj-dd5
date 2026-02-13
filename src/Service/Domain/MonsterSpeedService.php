<?php
namespace src\Service\Domain;

use src\Domain\Monster\Monster;
use src\Repository\MonsterSpeedRepository;
use src\Repository\SpeedTypeRepository;

class MonsterSpeedService
{
    public function __construct(
        private MonsterSpeedRepository $speedRepo,
        private SpeedTypeRepository $typeRepo
    ) {}

    public function getSpeedData(Monster $monster): array
    {
        $types = $this->typeRepo->findAll(); // walk, fly, swim, climb, burrow
        $speeds = $this->speedRepo->findByMonster($monster->id);

        $result = [];

        foreach ($types as $type) {
            $speed = $speeds[$type->slug] ?? null;

            $result[$type->slug] = [
                'label'   => $type->label,
                'enabled' => $speed !== null,
                'value'   => $speed?->value ?? null,
                'extra'   => $speed?->extra ?? null,
            ];
        }

        return $result;
    }
}

