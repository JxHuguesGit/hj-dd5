<?php
namespace src\Entity;

class TypeDamage extends Entity
{

    public function __construct(
        protected int $id,
        protected string $code
    ) {

    }

}
