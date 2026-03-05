<?php
namespace src\Domain\Entity;

use src\Constant\Constant;
use src\Constant\Field as F;
use src\Constant\FieldType;
use src\Domain\Entity;

class MonsterType extends Entity
{
    public const FIELDS = [
        F::ID,
        F::NAME,
    ];
    public const FIELD_TYPES = [
        F::NAME => FieldType::STRING,
    ];

    public function stringify(): string
    {
        return ($this->getNameAndGender())[Constant::LABEL];
    }

    public function getNameAndGender(): array
    {
        $mapping = [
            'Elemental'      => [Constant::LABEL => 'Elémentaire', 'gender' => 'm'],
            'Humanoid'       => [Constant::LABEL => 'Humanoïde', 'gender' => 'm'],
            'Aberration'     => [Constant::LABEL => 'Aberration', 'gender' => 'f'],
            'Dragon'         => [Constant::LABEL => 'Dragon', 'gender' => 'm'],
            'Monstrosity'    => [Constant::LABEL => 'Monstruosité', 'gender' => 'f'],
            'Beast'          => [Constant::LABEL => 'Bête', 'gender' => 'f'],
            'Celestial'      => [Constant::LABEL => 'Céleste', 'gender' => 'm'],
            'Construct'      => [Constant::LABEL => 'Construction', 'gender' => 'f'],
            'Fiend'          => [Constant::LABEL => 'Démon', 'gender' => 'm'],
            'Fey'            => [Constant::LABEL => 'Fée', 'gender' => 'f'],
            'Plant'          => [Constant::LABEL => 'Plante', 'gender' => 'f'],
            'Undead'         => [Constant::LABEL => 'Mort-vivant', 'gender' => 'm'],
            'Ooze'           => [Constant::LABEL => 'Vase', 'gender' => 'f'],
            'Giant'          => [Constant::LABEL => 'Géant', 'gender' => 'm'],
            'CelFie'         => [Constant::LABEL => 'Céleste ou Démon', 'gender' => 'm'],
            'CelFeyFie'      => [Constant::LABEL => 'Céleste, Fée ou Démon', 'gender' => 'm'],
        ];

        return $mapping[$this->name] ?? [Constant::LABEL => 'Type de monstre non identifié', 'gender' => 'm'];
    }
}
