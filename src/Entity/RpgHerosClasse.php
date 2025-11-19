<?php
namespace src\Entity;

class RpgHerosClasse extends Entity
{

    public function __construct(
        protected int $id,
        protected int $herosId,
        protected int $classeId,
        protected int $niveau
    ) {

    }

}
