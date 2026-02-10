<?php
namespace src\Repository;

use src\Constant\Table;
use src\Domain\Entity\Spell;

class SpellRepository extends Repository implements SpellRepositoryInterface
{
    public const TABLE = Table::SPELL;
    
    public function getEntityClass(): string
    {
        return Spell::class;
    }

    public function find(int $id): ?Spell
    {
        throw new \Exception('find Not implemented');
    }
}
