<?php
namespace src\Service;

use src\Domain\Weapon as DomainWeapon;

class WeaponPropertiesFormatter
{
    public function format(DomainWeapon $weapon): string
    {
        var_dump($weapon);
        $properties = [];
        foreach ($weapon->properties as $propValue) {
            $name = $propValue->property->name;
            switch ($name) {
                case 'Munitions':
                    if ($propValue->typeAmmunition) {
                        $properties[] = 'Munitions (' . $propValue->typeAmmunition->name . ')';
                    }
                break;
                case 'Portée':
                    if ($propValue->minRange && $propValue->maxRange) {
                        $properties[] = 'Portée (' . $propValue->minRange . '/' . $propValue->maxRange . ')';
                    }
                break;
                case 'Lancer':
                    if ($propValue->minRange && $propValue->maxRange) {
                        $properties[] = 'Lancer (' . $propValue->minRange . '/' . $propValue->maxRange . ')';
                    }
                break;
                case 'Polyvalente':
                    if ($propValue->damageDie) {
                        $properties[] = 'Polyvalente (' . $propValue->damageDie->diceCount . 'd' . $propValue->damageDie->diceFaces . ')';
                    }
                break;
                default:
                    $properties[] = $name;
                    break;
            }
        }
        return implode(', ', $properties);
    }
}
