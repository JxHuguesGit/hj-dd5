<?php
namespace src\Entity;

class RpgTypeDamage extends Entity
{

    public function __construct(
        protected int $id,
        protected string $name
    ) {

    }
}
