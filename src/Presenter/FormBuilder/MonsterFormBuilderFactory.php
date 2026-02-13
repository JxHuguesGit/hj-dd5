<?php
namespace src\Presenter\FormBuilder;

use src\Service\Domain\MonsterSpeedService;
use src\Service\MonsterTypeService;

class MonsterFormBuilderFactory
{
    public function __construct(
        private MonsterSpeedService $speedService,
        private MonsterTypeService $typeService
    ) {}

    public function create(): MonsterFormBuilder
    {
        return new MonsterFormBuilder(
            $this->speedService,
            $this->typeService
        );
    }
}
