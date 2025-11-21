<?php
namespace src\Entity;

use src\Constant\Field;

class RpgTypeMonstre extends Entity
{
    public const TABLE = 'rpgTypeMonstre';
    public const FIELDS = [
        Field::ID,
        Field::NAME,
    ];

    protected string $name;

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
