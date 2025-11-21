<?php
namespace src\Entity;

use src\Utils\Utils;

class CharacterStats
{
    protected int $hp;
    protected int $strScore;
    protected int $dexScore;
    protected int $conScore;
    protected int $intScore;
    protected int $wisScore;
    protected int $chaScore;
    protected int $profBonus;
    protected int $percPassive;

    public function __construct(array $attributes = [])
    {
        $this->hp           = $attributes['hp'] ?? 0;
        $this->strScore     = $attributes['strScore'] ?? 0;
        $this->dexScore     = $attributes['dexScore'] ?? 0;
        $this->conScore     = $attributes['conScore'] ?? 0;
        $this->intScore     = $attributes['intScore'] ?? 0;
        $this->wisScore     = $attributes['wisScore'] ?? 0;
        $this->chaScore     = $attributes['chaScore'] ?? 0;
        $this->profBonus    = $attributes['profBonus'] ?? 0;
        $this->percPassive  = $attributes['percPassive'] ?? 0;
    }

    public function getField(string $field)
    {
        // Premier niveau : propriétés de l'entité
        if (property_exists($this, $field)) {
            return $this->{$field};
        }
    
        throw new \InvalidArgumentException("Le champ '$field' n'existe pas.");
    }
    
    public function setField(string $field, mixed $value): self
    {
        if (property_exists($this, $field)) {
            $this->{$field} = $value;
            return $this;
        }

        throw new \InvalidArgumentException("Le champ '$field' n'existe pas.");
    }
    
}
