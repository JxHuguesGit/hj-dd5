<?php
namespace src\Domain\Entity;

use src\Constant\Constant;
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
        return ($this->getNameAndGender())[Constant::CST_LABEL];
    }

    public function getNameAndGender(): array
    {
        $mapping = [
            'Elemental'      => [Constant::CST_LABEL => 'Elémentaire', 'gender' => 'm'],
            'Humanoid'       => [Constant::CST_LABEL => 'Humanoïde', 'gender' => 'm'],
            'Aberration'     => [Constant::CST_LABEL => 'Aberration', 'gender' => 'f'],
            'Dragon'         => [Constant::CST_LABEL => 'Dragon', 'gender' => 'm'],
            'Monstrosity'    => [Constant::CST_LABEL => 'Monstruosité', 'gender' => 'f'],
            'Beast'          => [Constant::CST_LABEL => 'Bête', 'gender' => 'f'],
            'Celestial'      => [Constant::CST_LABEL => 'Céleste', 'gender' => 'm'],
            'Construct'      => [Constant::CST_LABEL => 'Construction', 'gender' => 'f'],
            'Fiend'          => [Constant::CST_LABEL => 'Démon', 'gender' => 'm'],
            'Fey'            => [Constant::CST_LABEL => 'Fée', 'gender' => 'f'],
            'Plant'          => [Constant::CST_LABEL => 'Plante', 'gender' => 'f'],
            'Undead'         => [Constant::CST_LABEL => 'Mort-vivant', 'gender' => 'm'],
            'Ooze'           => [Constant::CST_LABEL => 'Vase', 'gender' => 'f'],
            'Giant'          => [Constant::CST_LABEL => 'Géant', 'gender' => 'm'],
            'CelFie'         => [Constant::CST_LABEL => 'Céleste ou Démon', 'gender' => 'm'],
            'CelFeyFie'      => [Constant::CST_LABEL => 'Céleste, Fée ou Démon', 'gender' => 'm'],
        ];

        return $mapping[$this->name] ?? [Constant::CST_LABEL => 'Type de monstre non identifié', 'gender' => 'm'];
    }
}
