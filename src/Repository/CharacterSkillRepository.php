<?php
namespace src\Repository;

use src\Constant\Table;
use src\Domain\Entity\CharacterSkill;

final class CharacterSkillRepository extends Repository implements CharacterSkillRepositoryInterface
{
    public const TABLE = Table::CHARACTERSKILL;

    public function getEntityClass(): string
    {
        return CharacterSkill::class;
    }
}
