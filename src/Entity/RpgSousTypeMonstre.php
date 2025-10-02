<?php
namespace src\Entity;

class RpgSousTypeMonstre extends Entity
{

    public function __construct(
        protected int $id,
        protected int $monstreTypeId,
        protected string $name
    ) {

    }

    public function getStrName(): string
    {
        switch ($this->name) {
            case 'Chromatic' :
                $returned = 'Chromatique';
            break;
            case 'Metallic' :
                $returned = 'Métallique';
            break;
            case 'Dinosaur' :
                $returned = 'Dinosaure';
            break;
            case 'Wizard' :
                $returned = 'Magicien';
            break;
            case 'Cleric' :
                $returned = 'Clerc';
            break;
            case 'Demon' :
                $returned = 'Démon';
            break;
            case 'Devil' :
                $returned = 'Diable';
            break;
            case 'Goblinoid' :
                $returned = 'Goblinoïde';
            break;
            case 'Genie' :
                $returned = 'Génie';
            break;
            case 'Angel' :
                $returned = 'Ange';
            break;
            case 'Yugoloth' :
            case 'Titan' :
            case 'Lycanthrope' :
            case 'Beholder' :
            case 'Gith' :
                $returned = $this->name;
            break;
            default :
                $returned = 'Type de monstre non identifié';
            break;
        }
        return $returned;
    }
}
