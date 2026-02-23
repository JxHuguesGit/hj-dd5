<?php
namespace src\Domain\CharacterCreation;

use src\Constant\Template;
use src\Domain\CharacterCreation\Step\NameStep;
use src\Domain\CharacterCreation\Step\OriginStep;
use src\Renderer\TemplateRenderer;
use src\Service\Writer\CharacterDraftWriter;

class CharacterCreationFlow
{
    public function __construct(
        private CharacterDraft $draft,
        private CharacterDraftWriter $writer,
        private TemplateRenderer $renderer
    ) {}

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

    public function getCurrentStepId(): string
    {
        $current = $this->draft->createStep ?: $this->firstStep();
        return $this->hasStep($current) ? $current : $this->firstStep();
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

    public function handle(array $post): string
    {
        $current = $this->getCurrentStepId();
        $step = $this->getStep($current);
        if (!empty($post) && $step->validate($post)) {
            $step->save($this->draft, $post);
            $this->draft->createStep = $this->nextStep($current) ?? 'done';
            $this->draft->touch();
            $this->writer->save($this->draft);
            return $this->draft->createStep === 'done' ? 'done' : $this->draft->createStep;
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
                [$this->renderer->render(Template::CREATE_SIDEBAR, $step->sidebar($this->draft))],
                $step->render($this->draft)
            )
        );
    }

    public function getDraft(): CharacterDraft
    {
        return $this->draft;
    }


}
