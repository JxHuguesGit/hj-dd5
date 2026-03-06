<?php
namespace src\Domain\Entity;

use src\Constant\Constant as C;
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
        return ($this->getNameAndGender())[C::LABEL];
    }

    public function getNameAndGender(): array
    {
        $mapping = [
            'Elemental'      => [C::LABEL => 'Elémentaire', 'gender' => 'm'],
            'Humanoid'       => [C::LABEL => 'Humanoïde', 'gender' => 'm'],
            'Aberration'     => [C::LABEL => 'Aberration', 'gender' => 'f'],
            'Dragon'         => [C::LABEL => 'Dragon', 'gender' => 'm'],
            'Monstrosity'    => [C::LABEL => 'Monstruosité', 'gender' => 'f'],
            'Beast'          => [C::LABEL => 'Bête', 'gender' => 'f'],
            'Celestial'      => [C::LABEL => 'Céleste', 'gender' => 'm'],
            'Construct'      => [C::LABEL => 'Construction', 'gender' => 'f'],
            'Fiend'          => [C::LABEL => 'Démon', 'gender' => 'm'],
            'Fey'            => [C::LABEL => 'Fée', 'gender' => 'f'],
            'Plant'          => [C::LABEL => 'Plante', 'gender' => 'f'],
            'Undead'         => [C::LABEL => 'Mort-vivant', 'gender' => 'm'],
            'Ooze'           => [C::LABEL => 'Vase', 'gender' => 'f'],
            'Giant'          => [C::LABEL => 'Géant', 'gender' => 'm'],
            'CelFie'         => [C::LABEL => 'Céleste ou Démon', 'gender' => 'm'],
            'CelFeyFie'      => [C::LABEL => 'Céleste, Fée ou Démon', 'gender' => 'm'],
        ];

        return $mapping[$this->name] ?? [C::LABEL => 'Type de monstre non identifié', 'gender' => 'm'];
    }
}
