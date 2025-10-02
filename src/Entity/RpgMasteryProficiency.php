<?php
namespace src\Entity;

class RpgMasteryProficiency extends Entity
{

    public function __construct(
        protected int $id,
        protected string $name
    ) {

    }

}