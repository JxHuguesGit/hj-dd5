<?php
namespace src\Entity;

class RpgLanguage extends Entity
{

    public function __construct(
        protected int $id,
        protected string $name
    ) {

    }
}