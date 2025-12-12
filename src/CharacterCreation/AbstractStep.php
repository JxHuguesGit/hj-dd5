<?php
namespace src\CharacterCreation;

use src\Entity\RpgHeros;

abstract class AbstractStep
{
    protected RpgHeros $hero;
    protected array $deps;
    // type callable, mais Sonar hurle.
    protected $renderer;
    protected array $stepMap;

    public function __construct(RpgHeros $hero, array $deps, callable $renderer, array $stepMap)
    {
        $this->hero = $hero;
        $this->deps = $deps;
        $this->renderer = $renderer;
        $this->stepMap = $stepMap;
    }

    protected function getDep(string $key)
    {
        if (!array_key_exists($key, $this->deps)) {
            throw new \InvalidArgumentException("Dépendance inconnue '$key' dans l'étape ".static::class);
        }
        return $this->deps[$key] ?? null;
    }

    protected function getRender(string $template, array $variables = []): string
    {
        return call_user_func($this->renderer, $template, $variables);
    }
    
    /**
     * Valeur affichée dans la sidebar pour cette étape.
     */
    public function getSidebarValue(): string
    {
        // Par défaut vide, les sous-classes peuvent override
        return '';
    }

    public static function getSidebarLabel(): string
    {
        // fallback moche mais sûr
        return static::class;
    }
        
    /**
     * Valide les données POST et met à jour l'entité.
     */
    abstract public function validateAndSave(): void;

    /**
     * Expected return format:
     * [
     *   'template' => string,
     *   'variables' => array
     * ]
     */
    abstract public function renderStep(): array;
}
