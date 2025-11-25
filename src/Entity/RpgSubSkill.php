<?php
namespace src\Entity;

use src\Constant\Field;
use src\Repository\RpgSkill as RepositoryRpgSkill;

class RpgSubSkill extends Entity
{
    public const TABLE = 'rpgSubSkill';
    public const FIELDS = [
        Field::ID,
        Field::NAME,
        Field::SKILLID,
        Field::DESCRIPTION,
    ];

    public const FIELD_TYPES = [
        Field::NAME => 'string',
        Field::SKILLID => 'intPositive',
        Field::DESCRIPTION => 'string',
    ];

    protected string $name = '';
    protected int $skillId = 0;
    protected string $description = '';

    private ?RpgSkill $skillCache = null;

    public function stringify(): string
    {
        return sprintf(
            "%s - Description : %s",
            $this->getName(),
            $this->getExcerpt()
        );
    }

    public function getSkill(): ?RpgSkill
    {
        return $this->getRelatedEntity('skillCache', RepositoryRpgSkill::class, $this->skillId);
    }
    
    public function getExcerpt(int $max = 80): string
    {
        return mb_strlen($this->description) > $max
            ? mb_substr($this->description, 0, $max) . '...'
            : $this->description;
    }
}
