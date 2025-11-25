<?php
namespace src\Entity;

use src\Constant\Field;

class RpgTypeMonstre extends Entity
{
    public const TABLE = 'rpgMonsterType';
    public const FIELDS = [
        Field::ID,
        Field::NAME,
    ];
    public const FIELD_TYPES = [
        Field::NAME => 'string',
    ];
    
    protected string $name = '';

    public function stringify(): string
    {
        $gender = '';
        return $this->getStrName($gender);
    }

    /**
     * TODO
     *
     * Retourne le nom traduit et le genre grammatical
     *
    *public function getStrName(): array
    *{
    *    $mapping = [
    *        'Elemental'      => ['label' => 'Elémentaire', 'gender' => 'm'],
    *        'Humanoid'       => ['label' => 'Humanoïde', 'gender' => 'm'],
    *        'Aberration'     => ['label' => 'Aberration', 'gender' => 'f'],
    *        'Dragon'         => ['label' => 'Dragon', 'gender' => 'm'],
    *        'Monstrosity'    => ['label' => 'Monstruosité', 'gender' => 'f'],
    *        'Beast'          => ['label' => 'Bête', 'gender' => 'f'],
    *        'Celestial'      => ['label' => 'Céleste', 'gender' => 'm'],
    *        'Construct'      => ['label' => 'Construction', 'gender' => 'f'],
    *        'Fiend'          => ['label' => 'Démon', 'gender' => 'm'],
    *        'Fey'            => ['label' => 'Fée', 'gender' => 'f'],
    *        'Plant'          => ['label' => 'Plante', 'gender' => 'f'],
    *        'Undead'         => ['label' => 'Mort-vivant', 'gender' => 'm'],
    *        'Ooze'           => ['label' => 'Vase', 'gender' => 'f'],
    *        'Giant'          => ['label' => 'Géant', 'gender' => 'm'],
    *        'CelFie'         => ['label' => 'Céleste ou Démon', 'gender' => 'm'],
    *        'CelFeyFie'      => ['label' => 'Céleste, Fée ou Démon', 'gender' => 'm'],
    *    ];

    *    return $mapping[$this->name] ?? ['label' => 'Type de monstre non identifié', 'gender' => 'm'];
    *}
     */

    public function getStrName(string &$gender): string
    {
        $gender = 'm';
        switch ($this->name) {
            case 'Elemental' :
                $returned = 'Elémentaire';
            break;
            case 'Humanoid' :
                $returned = 'Humanoïde';
            break;
            case 'Aberration' :
                $gender = 'f';
                $returned = 'Aberration';
            break;
            case 'Dragon' :
                $returned = 'Dragon';
            break;
            case 'Monstrosity' :
                $gender = 'f';
                $returned = 'Monstruosité';
            break;
            case 'Beast' :
                $gender = 'f';
                $returned = 'Bête';
            break;
            case 'Celestial' :
                $returned = 'Céleste';
            break;
            case 'Construct' :
                $gender = 'f';
                $returned = 'Construction';
            break;
            case 'Fiend' :
                $returned = 'Démon';
            break;
            case 'Fey' :
                $gender = 'f';
                $returned = 'Fée';
            break;
            case 'Plant' :
                $gender = 'f';
                $returned = 'Plante';
            break;
            case 'Undead' :
                $returned = 'Mort-vivant';
            break;
            case 'Ooze' :
                $gender = 'f';
                $returned = 'Vase';
            break;
            case 'Giant' :
                $returned = 'Géant';
            break;
            case 'CelFie' :
                $returned = 'Céleste ou Démon';
            break;
            case 'CelFeyFie' :
                $returned = 'Céleste, Fée ou Démon';
            break;
            default :
                $returned = 'Type de monstre non identifié';
            break;
        }
        return $returned;
    }
}
