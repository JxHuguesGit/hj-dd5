<?php
namespace src\Entity;

class RpgCondition extends Entity
{

    public function __construct(
        protected int $id,
        protected string $name,
        protected string $description
    ) {

    }
}
