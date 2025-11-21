<?php
namespace src\CharacterCreation;

use src\Entity\RpgHeros;
use src\Constant\Field;
use src\Constant\Template;

class SidebarRenderer
{
    private RpgHeros $hero;
    private array $deps;
    private $renderer;
    private array $stepMap;

    public function __construct(RpgHeros $hero, array $deps, callable $renderer, array $stepMap)
    {
        $this->hero = $hero;
        $this->deps = $deps;
        $this->renderer = $renderer;
        $this->stepMap = $stepMap;
    }

    public function render(): string
    {
        $currentStep = $this->hero->getField(Field::CREATESTEP) ?: array_key_first($this->stepMap);

        $stepsToDisplay = [];
        foreach ($this->stepMap as $key => $class) {
            $stepsToDisplay[] = $key;
            if ($key === $currentStep) {
                break;
            }
        }

        $baseUrl = '/wp-admin/admin.php?page=hj-dd5/admin_manage.php&onglet=character&id='.$this->hero->getField(Field::ID).'&step=';
        $html = '';

        // Génération du HTML
        foreach ($stepsToDisplay as $stepKey) {
            $class = $this->stepMap[$stepKey];
            $stepObj = new $class($this->hero, $this->deps, $this->renderer, $this->stepMap);

            $label = $class::getSidebarLabel();
            $value = $stepObj->getSidebarValue();

            $html .= sprintf(
                '<p><strong><a href="%s" class="text-black">%s</a> :</strong> <span id="sidebar%s">%s</span></p>',
                $baseUrl.$stepKey,
                ucfirst($label),
                ucfirst($stepKey),
                htmlspecialchars($value)
            );
        }

        // Injection dans le template
        return call_user_func($this->renderer, Template::CREATE_SIDEBAR, [$html]);
    }
}

