<?php
namespace src\Domain\Monster;

use src\Constant\Constant;
use src\Constant\Field;
use src\Domain\Entity\TypeMonster;

final class MonsterType
{
    public function __construct(
        private Monster $monster
    ) {}

    public function getEntity(): ?TypeMonster
    {
        return new TypeMonster([
            Field::NAME => $this->monster->getField(Field::TYPMSTNAME) ?? ''
        ]);
    }

    public function getName(): string
    {
        return ($this->getEntity()?->getNameAndGender())[Constant::CST_LABEL];
    }
}
