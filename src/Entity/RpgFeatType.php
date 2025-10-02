<?php
namespace src\Entity;

class RpgFeatType extends Entity
{

    public function __construct(
        protected int $id,
        protected string $name
    ) {

    }

}