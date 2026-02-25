<?php
namespace src\Domain\CharacterCreation;

use src\Constant\Constant;
use src\Constant\Template;
use src\Domain\CharacterCreation\Step\NameStep;
use src\Domain\CharacterCreation\Step\OriginStep;
use src\Domain\Character\Character;
use src\Exception\InterfaceException;
use src\Renderer\TemplateRenderer;
use src\Service\Domain\CharacterServices;

class CharacterCreationFlow
{
    public function __construct(
        private Character $character,
        private CharacterServices $services,
        private TemplateRenderer $renderer
    ) {}

    public function steps(): array
    {
        return [
            Constant::CST_NAME => NameStep::class,
            Constant::ORIGIN   => OriginStep::class,
        ];
    }

    public function firstStep(): string
    {
        return array_key_first($this->steps());
    }

    public function getCurrentStepId(): string
    {
        $current = $this->character->createStep ?: $this->firstStep();
        return $this->hasStep($current) ? $current : $this->firstStep();
    }

    public function nextStep(string $current): ?string
    {
        $keys  = array_keys($this->steps());
        $index = array_search($current, $keys, true);

        return $keys[$index + 1] ?? null;
    }

    public function previousStep(string $current): ?string
    {
        $keys  = array_keys($this->steps());
        $index = array_search($current, $keys, true);

        return $index > 0 ? $keys[$index - 1] : null;
    }

    public function getStep(string $stepId): StepInterface
    {
        $steps = $this->steps();

        if (! isset($steps[$stepId])) {
            throw new \InvalidArgumentException("Unknown step '$stepId'");
        }

        $class = $steps[$stepId];
        $step  = new $class();

        if (! $step instanceof StepInterface) {
            throw new InterfaceException($class);
        }

        return $step;
    }

    public function hasStep(string $stepId): bool
    {
        return array_key_exists($stepId, $this->steps());
    }

    public function getAllStepInstances(): array
    {
        $instances = [];
        foreach ($this->steps() as $id => $class) {
            $instances[$id] = new $class();
        }
        return $instances;
    }

    public function handle(array $post): string
    {
        $current = $this->getCurrentStepId();
        $step    = $this->getStep($current);
        if (! empty($post) && $step->validate($post)) {
            // A terme, mettre 'done' et non $current si on a atteint la dernière étape.
            $this->character->createStep = $this->nextStep($current) ?? $current;
            $this->character->touch();
            $step->save($this->services, $this->character, $post);
            return $this->character->createStep;
        }

        return $current;
    }

    public function render(?string $stepId = null): string
    {
        $stepId = $stepId ?? $this->getCurrentStepId();
        if ($stepId === 'done') {
            return '<div class="alert alert-success">Personnage créé ✅</div>';
        }
        $step = $this->getStep($stepId);
        return $this->renderer->render(
            $step->template,
            array_merge(
                [$this->renderer->render(Template::CREATE_SIDEBAR, $step->sidebar($this->character))],
                $step->render($this->character)
            )
        );
    }

    public function getCharacter(): Character
    {
        return $this->character;
    }

}
