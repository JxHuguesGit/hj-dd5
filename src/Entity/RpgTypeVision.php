<?php
namespace src\Entity;

class RpgTypeVision extends Entity
{

    public function __construct(
        protected int $id,
        protected string $name,
        protected string $ukTag
    ) {

    }
}
