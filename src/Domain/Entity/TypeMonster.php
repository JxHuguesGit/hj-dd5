<?php
namespace src\Domain\Entity;

use src\Constant\Field;
use src\Constant\FieldType;
use src\Domain\Entity;

class TypeMonster extends Entity
{
    public const FIELDS = [
        Field::ID,
        Field::NAME,
    ];
    public const FIELD_TYPES = [
        Field::NAME => FieldType::STRING,
    ];
    
    public function stringify(): string
    {
        return ($this->getNameAndGender())['label'];
    }

    public function getNameAndGender(): array
    {
        $mapping = [
            'Elemental'      => ['label' => 'Elémentaire', 'gender' => 'm'],
            'Humanoid'       => ['label' => 'Humanoïde', 'gender' => 'm'],
            'Aberration'     => ['label' => 'Aberration', 'gender' => 'f'],
            'Dragon'         => ['label' => 'Dragon', 'gender' => 'm'],
            'Monstrosity'    => ['label' => 'Monstruosité', 'gender' => 'f'],
            'Beast'          => ['label' => 'Bête', 'gender' => 'f'],
            'Celestial'      => ['label' => 'Céleste', 'gender' => 'm'],
            'Construct'      => ['label' => 'Construction', 'gender' => 'f'],
            'Fiend'          => ['label' => 'Démon', 'gender' => 'm'],
            'Fey'            => ['label' => 'Fée', 'gender' => 'f'],
            'Plant'          => ['label' => 'Plante', 'gender' => 'f'],
            'Undead'         => ['label' => 'Mort-vivant', 'gender' => 'm'],
            'Ooze'           => ['label' => 'Vase', 'gender' => 'f'],
            'Giant'          => ['label' => 'Géant', 'gender' => 'm'],
            'CelFie'         => ['label' => 'Céleste ou Démon', 'gender' => 'm'],
            'CelFeyFie'      => ['label' => 'Céleste, Fée ou Démon', 'gender' => 'm'],
        ];

        return $mapping[$this->name] ?? ['label' => 'Type de monstre non identifié', 'gender' => 'm'];
    }
}
