<?php
namespace src\Controller;

use src\Constant\Field;
use src\Entity\RpgClasse as EntityRpgClasse;

class RpgClasse extends Utilities
{
    protected EntityRpgClasse $rpgClasse;

    public function getRadioForm(string $prefix, bool $checked=false): string
    {
        $id = $this->rpgClasse->getField(Field::ID);
        $name = $this->rpgClasse->getField(Field::NAME);
        return '<div class="form-check">'
                . '<input class="" type="radio" name="'.$prefix.'" value="'.$id.'" id="'.$prefix.$id.'"'.($checked?' checked':'').'>'
                . '<label class="form-check-label" for="'.$prefix.$id.'">'.$name.'</label>'
                . '</div>';
    }
}
