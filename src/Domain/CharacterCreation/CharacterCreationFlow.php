<?php
namespace src\Domain\CharacterCreation;

use src\Domain\CharacterCreation\Step\NameStep;
use src\Domain\CharacterCreation\Step\OriginStep;

class CharacterCreationFlow
{
    public function steps(): array
    {
        return [
            'name'    => NameStep::class,
            'origin'  => OriginStep::class,
        ];
    }

    public function firstStep(): string
    {
        return array_key_first($this->steps());
    }

    public function nextStep(string $current): ?string
    {
        $keys = array_keys($this->steps());
        $index = array_search($current, $keys, true);

        return $keys[$index + 1] ?? null;
    }

    public function previousStep(string $current): ?string
    {
        $keys = array_keys($this->steps());
        $index = array_search($current, $keys, true);

        return $index > 0 ? $keys[$index - 1] : null;
    }

    public function getStep(string $stepId): StepInterface
    {
        $steps = $this->steps();

        if (!isset($steps[$stepId])) {
            throw new \InvalidArgumentException("Unknown step '$stepId'");
        }

        $class = $steps[$stepId];
        $step = new $class();

        if (!$step instanceof StepInterface) {
            throw new \RuntimeException("$class must implement StepInterface");
        }

        return $step;
    }

    public function hasStep(string $stepId): bool
    {
        return array_key_exists($stepId, $this->steps());
    }

    public function getAllStepInstances(): array {
        $instances = [];
        foreach ($this->steps() as $id => $class) {
            $instances[$id] = new $class();
        }
        return $instances;
    }

}
