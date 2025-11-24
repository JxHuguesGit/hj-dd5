<?php
namespace src\CharacterCreation;

use src\Entity\RpgHeros;
use src\Utils\Session;

class CharacterCreationFlow
{
    private const DEFAULT_STEP = 'name';
    private const STEP_MAP = [
        'name'    => NameStep::class,
        'origin'  => OriginStep::class,
        'species' => SpeciesStep::class,
        'originFeat' => OriginFeatStep::class,
        'classe'     => ClasseStep::class,
        'skillTool'  => SkillStep::class,
    ];

    private RpgHeros $hero;
    private array $deps;
    private $renderer;
    
    public function __construct(
        RpgHeros $hero,
        array $deps,
        callable $renderer
    ) {
        $this->hero = $hero;
        $this->deps = $deps;
        $this->renderer = $renderer;
    }

    /**
      * @return array{template: string, variables: array}
      */
    public function handle(): array
    {
        // 1) Navigation manuelle via GET
        $getStep = Session::fromGet('step');
        if ($getStep) {
            $key = $this->resolveStepKey($getStep);
            return $this->makeStep(self::STEP_MAP[$key])->renderStep();
        }

        // 2) Validation via POST
        $postedStep = Session::fromPost('herosForm');
        if ($postedStep) {
            $key = $this->resolveStepKey($postedStep);

            $stepObj = $this->makeStep(self::STEP_MAP[$key]);
            $stepObj->validateAndSave();

            // Après validation, l'étape suivante est définie par le profil du héros
            $nextKey = $this->hero->getField('createStep') ?: null;
            $nextKey = $this->resolveStepKey($nextKey);

            return $this->makeStep(self::STEP_MAP[$nextKey])->renderStep();
        }

        // 3) Aucune navigation, aucun POST → on affiche l’étape en base
        $stored = $this->hero->getField('createStep') ?: null;
        $key = $this->resolveStepKey($stored);

        return $this->makeStep(self::STEP_MAP[$key])->renderStep();
    }

    private function resolveStepKey(?string $requested): string
    {
        if ($requested && isset(self::STEP_MAP[$requested])) {
            return $requested;
        }

        // fallback sur la valeur en base si elle existe et est valide
        $stored = $this->hero->getField('createStep') ?: null;
        if ($stored && isset(self::STEP_MAP[$stored])) {
            return $stored;
        }

        // aucun step valide trouvé -> retourne la step par défaut
        return self::DEFAULT_STEP;
    }

    private function makeStep(string $class): AbstractStep
    {
        return new $class($this->hero, $this->deps, $this->renderer, self::STEP_MAP);
    }
}
