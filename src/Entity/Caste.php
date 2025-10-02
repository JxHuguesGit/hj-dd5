<?php
namespace src\Entity;

class Caste extends Entity
{

    public function __construct(
        protected int $id,
        protected string $code
    ) {

    }

    public function getCode(): string
    {
        return $this->code;
    }

}