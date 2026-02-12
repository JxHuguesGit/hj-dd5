<?php
namespace src\Domain\Monster;

use src\Constant\Field;
use src\Domain\Entity\SubTypeMonster;


final class MonsterSubType
{
    public function __construct(
        private Monster $monster
    ) {}

    public function getEntity(): SubTypeMonster
    {
        return new SubTypeMonster([
            Field::NAME => $this->monster->getField(Field::SSTYPMSTNAME) ?? ''
        ]);
    }

    public function getName(): string
    {
        return $this->getEntity()->getStrName();
    }
}
