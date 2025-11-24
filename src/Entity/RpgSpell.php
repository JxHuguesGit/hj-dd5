<?php
namespace src\Entity;

use src\Controller\RpgSpell as ControllerRpgSpell;
use src\Enum\ClassEnum;

class RpgSpell extends Entity
{
    public const TABLE  = null;
    public const FIELDS = [];
    
    public string $title;
    public ?string $content;
    public ?string $tempsIncantation;
    public ?string $portee;
    public ?string $duree;
    public ?int $niveau;
    public ?string $ecole;
    public ?array $classes;
    public ?array $composantes;
    public ?string $composanteMaterielle;
    public bool $concentration;
    public bool $rituel;
    public ?string $typeAmelioration;
    public ?string $ameliorationDescription;

    public function getController(): ControllerRpgSpell
    {
        $controller = new ControllerRpgSpell;
        $controller->setField('rpgSpell', $this);
        return $controller;
    }
    
    public function getTitle(): string
    {
        return $this->title;
    }
    
    public function getNiveau() : ?int
    {
        return $this->niveau;
    }
    
    public function getEcole(): ?string
    {
        return $this->ecole;
    }
    
    public function getClasses(): array
    {
        return $this->classes;
    }
    
    public function getDescription(): string
    {
        return $this->content;
    }
    
    public function getTypeAmelioration(): ?string
    {
        return $this->typeAmelioration;
    }

    public function getAmelioration(): string
    {
        return $this->ameliorationDescription ?? '';
    }

    private function getDureeConvertie(string $value): string
    {
        if (str_contains($value, 'min')) {
            $returned = intval($value) . ' minute' . (intval($value) > 1 ? 's' : '');
        } elseif (str_contains($value, 'rd')) {
            $returned = intval($value) . ' round' . (intval($value) > 1 ? 's' : '');
        } elseif (str_contains($value, 'hr')) {
            $returned = intval($value) . ' heure' . (intval($value) > 1 ? 's' : '');
        } elseif (str_contains($value, 'jr')) {
            $returned = intval($value) . ' jour' . (intval($value) > 1 ? 's' : '');
        } else {
            $returned = match ($value) {
                'diss'   => "Jusqu'à dissipation",
                'inst'   => 'Instantanée',
                'spec'   => 'Spéciale',
                'bonus'  => 'Action Bonus',
                'action' => 'Action',
                'reaction' => 'Réaction',
                default  => $value,
            };
                /*
    Jusqu'à 1 minute
    Jusqu'à 1 heure
    Jusqu'à 8 heures
    Dissipation/Déclenchement
                */
        }
        return $returned;
    }
    
    public function getFormattedDuree(bool $detail=true): string
    {
        $prefix = ($this->concentration && $detail)
            ? "Concentration, jusqu'à "
            : '';

        return $prefix . $this->getDureeConvertie($this->duree);
    }
    
    public function getFormattedComposantes(bool $detail=true): string
    {
        $str = implode(',', $this->composantes);
        if (in_array('M', $this->composantes) && $detail) {
            $str .= ' ('.$this->composanteMaterielle.')';
        }
        return $str;
    }
    
    public function getFormattedPortee(): string
    {
        return match ($this->portee) {
            'vue', 'contact' => ucwords($this->portee),
            'illim'   => 'Illimitée',
            'perso'   => 'Personnelle',
            'spec'    => 'Spéciale',
            default   => $this->formatPorteeDistance($this->portee),
        };
    }

    private function formatPorteeDistance($value): string
    {
        $returned = (str_contains($value, 'km'))
            ? substr($value, 0, -2) . ' km'
            : substr($value, 0, -1) . ' m';

        return str_replace('.', ',', $returned);
    }
    
    public function getFormattedIncantation(): string
    {
        return $this->getDureeConvertie($this->tempsIncantation). ($this->rituel ? ' ou Rituel' : '');
    }
    
    public function getFormattedClasses(bool $parenthesis=true): string
    {
        $classes = array_map(
            fn(string $value) => ClassEnum::from($value)->label(),
            $this->classes
        );
        return $parenthesis ? '(' . implode(', ', $classes) . ')' : implode(', ', $classes);
    }
    
    public function getStrConcentration(): string
    {
        return $this->concentration ? 'Concentration' : '';
    }
    
    public function getStrRituel(): string
    {
        return $this->rituel ? 'Rituel' : '';
    }

}
