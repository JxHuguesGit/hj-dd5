<?php
namespace src\Domain\Monster;

use src\Constant\Constant;
use src\Constant\Field;
use src\Domain\Entity\MonsterType as EntityMonsterType;

final class MonsterType
{
    public function __construct(
        private Monster $monster
    ) {}

    public function getEntity(): ?EntityMonsterType
    {
        return new EntityMonsterType([
            Field::NAME => $this->monster->getField(Field::TYPMSTNAME) ?? ''
        ]);
    }

    public function getName(): string
    {
        return ($this->getEntity()?->getNameAndGender())[Constant::CST_LABEL];
    }
}
