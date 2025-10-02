<?php
namespace src\Entity;

class RpgAbility extends Entity
{

    public function __construct(
        protected int $id,
        protected string $name
    ) {

    }
}