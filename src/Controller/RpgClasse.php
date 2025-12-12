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
        return sprintf(
            '<div class="form-check"><input class="" type="radio" name="%1s" value="%2s" id="%1s%2s"%3s><label class="form-check-label" for="%1s%2s">%4s</label></div>',
            $prefix,
            $id,
            ($checked?' checked':''),
            $name
        );
    }
}
