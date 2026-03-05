<?php
namespace src\Domain\Monster;

use src\Constant\Field as F;
use src\Domain\Entity\MonsterSubType as EntityMonsterSubType;


final class MonsterSubType
{
    public function __construct(
        private Monster $monster
    ) {}

    public function getEntity(): EntityMonsterSubType
    {
        return new EntityMonsterSubType([
            F::NAME => $this->monster->getField(F::SSTYPMSTNAME) ?? ''
        ]);
    }

    public function getName(): string
    {
        return $this->getEntity()->getStrName();
    }
}
