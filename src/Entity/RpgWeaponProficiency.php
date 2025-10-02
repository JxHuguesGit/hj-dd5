<?php
namespace src\Entity;

class RpgWeaponProficiency extends Entity
{

    public function __construct(
        protected int $id,
        protected string $name
    ) {

    }
}
