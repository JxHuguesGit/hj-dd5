<?php
namespace src\Domain\Monster;

use src\Constant\Constant;
use src\Constant\Field as F;
use src\Domain\Entity\MonsterType as EntityMonsterType;

final class MonsterType
{
    public function __construct(
        private Monster $monster
    ) {}

    public function getEntity(): ?EntityMonsterType
    {
        return new EntityMonsterType([
            F::NAME => $this->monster->getField(F::TYPMSTNAME) ?? ''
        ]);
    }

    public function getName(): string
    {
        return ($this->getEntity()?->getNameAndGender())[Constant::LABEL];
    }
}
