<?php
namespace src\Entity;

class RpgTypeSpeed extends Entity
{

    public function __construct(
        protected int $id,
        protected string $name,
        protected string $ukTag,
        protected string $frTag
    ) {

    }
}
