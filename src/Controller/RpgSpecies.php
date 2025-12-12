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
        return sprintf(
            '<div class="form-check"><input class="" type="radio" name="characterSpeciesId" value="%1s" id="species%1s"%2s><label class="form-check-label" for="species%1s">%3s</label></div>',
            $id,
            $checked?' checked':'',
            $name
        );
    }
}
