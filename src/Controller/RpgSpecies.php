<?php
namespace src\Controller;

use src\Constant\Field;
use src\Entity\RpgSpecies as EntityRpgSpecies;

class RpgSpecies extends Utilities
{
    protected EntityRpgSpecies $rpgSpecies;

    public function __construct()
    {
        parent::__construct();

        $this->title = 'Espèces';
    }

    public function getRadioForm(bool $checked=false): string
    {
        $id = $this->rpgSpecies->getField(Field::ID);
        $name = $this->rpgSpecies->getField(Field::NAME);
        return '<div class="form-check">'
                . '<input class="" type="radio" name="characterSpeciesId" value="'.$id.'" id="species'.$id.'"'.($checked?' checked':'').'>'
                . '<label class="form-check-label" for="species'.$id.'">'.$name.'</label>'
                . '</div>';
    }
}
