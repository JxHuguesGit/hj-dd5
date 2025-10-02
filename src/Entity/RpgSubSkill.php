<?php
namespace src\Entity;

class RpgSubSkill extends Entity
{

    public function __construct(
        protected int $id,
        protected string $name,
        protected int $skillId,
        protected string $description
    ) {

    }

}
