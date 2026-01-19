<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Table;
use src\Domain\Spell as DomainSpell;

class SpellRepository extends Repository implements SpellRepositoryInterface
{
    public const TABLE = Table::SPELL;
    
    public function getEntityClass(): string
    {
        return DomainSpell::class;
    }

    public function find(int $id): ?DomainSpell
    {
        throw new \Exception('find Not implemented');
    }
}
