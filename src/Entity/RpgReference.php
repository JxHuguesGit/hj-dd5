<?php
namespace src\Entity;

class RpgReference extends Entity
{

    public function __construct(
        protected int $id,
        protected string $name
    ) {

    }
}
