<?php
namespace src\Repository;

use src\Constant\Table;
use src\Domain\Entity\OriginSkill;

class OriginSkillRepository extends Repository implements OriginSkillRepositoryInterface
{
    public const TABLE = Table::ORIGINSKILL;

    public function getEntityClass(): string
    {
        return OriginSkill::class;
    }
}
