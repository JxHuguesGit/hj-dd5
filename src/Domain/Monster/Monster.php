<?php
namespace src\Domain\Monster;

use src\Constant\Field;
use src\Constant\FieldType;
use src\Domain\Entity;

final class Monster extends Entity
{
    public const FIELDS = [
        Field::ID,
        Field::FRNAME,
        Field::NAME,
        Field::FRTAG,
        Field::UKTAG,
        Field::INCOMPLET,
        Field::SCORECR,
        Field::MSTTYPEID,
        Field::MSTSSTYPID,
        Field::SWARMSIZE,
        Field::MSTSIZE,
        Field::ALGNID,
        Field::SCORECA,
        Field::SCOREHP,
        Field::SPEED,
        Field::INITIATIVE,
        Field::LEGENDARY,
        Field::HABITAT,
        Field::REFID,
        Field::STRSCORE,
        Field::DEXSCORE,
        Field::CONSCORE,
        Field::INTSCORE,
        Field::WISSCORE,
        Field::CHASCORE,
        Field::PROFBONUS,
        Field::PERCPASSIVE,
        Field::EXTRA,

        Field::TYPMSTNAME,
        Field::ABBR,

        Field::SSTYPMSTNAME,

        Field::REFNAME,
    ];
    public const FIELD_TYPES = [
        Field::FRNAME       => FieldType::STRING,
        Field::NAME         => FieldType::STRING,
        Field::FRTAG        => FieldType::STRING,
        Field::UKTAG        => FieldType::STRING,
        Field::INCOMPLET    => FieldType::INTNULLABLE,
        Field::SCORECR      => FieldType::FLOAT,
        Field::MSTTYPEID    => FieldType::INT,
        Field::MSTSSTYPID   => FieldType::INTNULLABLE,
        Field::SWARMSIZE    => FieldType::INTNULLABLE,
        Field::MSTSIZE      => FieldType::INT,
        Field::ALGNID       => FieldType::INT,
        Field::SCORECA      => FieldType::INT,
        Field::SCOREHP      => FieldType::INT,
        Field::SPEED        => FieldType::STRING,
        Field::INITIATIVE   => FieldType::INT,
        Field::LEGENDARY    => FieldType::INT,
        Field::HABITAT      => FieldType::STRING,
        Field::REFID        => FieldType::INT,
        Field::STRSCORE     => FieldType::INT,
        Field::DEXSCORE     => FieldType::INT,
        Field::CONSCORE     => FieldType::INT,
        Field::INTSCORE     => FieldType::INT,
        Field::WISSCORE     => FieldType::INT,
        Field::CHASCORE     => FieldType::INT,
        Field::PROFBONUS    => FieldType::INT,
        Field::PERCPASSIVE  => FieldType::INT,
        Field::EXTRA        => FieldType::STRINGNULLABLE,

        Field::TYPMSTNAME   => FieldType::STRING,
        Field::ABBR         => FieldType::STRING,

        Field::SSTYPMSTNAME => FieldType::STRINGNULLABLE,

        Field::REFNAME      => FieldType::STRINGNULLABLE,
    ];
    
    /**
     * @SuppressWarnings("php:S1068")
     */
    private ?MonsterIdentity $identity = null;
    /**
     * @SuppressWarnings("php:S1068")
     */
    private ?MonsterClassification $classification = null;
    /**
     * @SuppressWarnings("php:S1068")
     */
    private ?MonsterCombatStats $combat = null;
    /**
     * @SuppressWarnings("php:S1068")
     */
    private ?CharacterStats $stats = null;
    
    // Relations 1-1
    private ?MonsterType $typeEntity = null;
    private ?MonsterSubType $subTypeEntity = null;
    private ?MonsterReference $referenceEntity = null;

    private function lazy(string $property, string $class): object
    {
        if ($this->{$property} === null) {
            $this->{$property} = new $class($this);
        }

        return $this->{$property};
    }

    public function identity(): MonsterIdentity
    {
        return $this->lazy('identity', MonsterIdentity::class);
    }

    public function classification(): MonsterClassification
    {
        return $this->lazy('classification', MonsterClassification::class);
    }

    public function combat(): MonsterCombatStats
    {
        return $this->lazy('combat', MonsterCombatStats::class);
    }

    public function stats(): CharacterStats
    {
        return $this->lazy('stats', CharacterStats::class);
    }

    public function stringify(): string
    {
        return $this->name;
    }

    public function getField(string $field): mixed
    {
        if (!in_array($field, self::FIELDS, true)) {
            throw new \InvalidArgumentException("Champ invalide : $field");
        }
        return $this->{$field} ?? null;
    }

    // -------------------------------------------------
    // Façades 1-1
    // -------------------------------------------------
    public function type(): MonsterType
    {
        if ($this->typeEntity === null) {
            $this->typeEntity = new MonsterType($this);
        }
        return $this->typeEntity;
    }

    public function subType(): MonsterSubType
    {
        if ($this->subTypeEntity === null) {
            $this->subTypeEntity = new MonsterSubType($this);
        }
        return $this->subTypeEntity;
    }


    public function reference(): MonsterReference
    {
        if ($this->referenceEntity === null) {
            $this->referenceEntity = new MonsterReference($this);
        }
        return $this->referenceEntity;
    }

    // -------------------------------------------------
    // Helpers pour le tableau / ListPresenter
    // -------------------------------------------------
    // -----------------------
    // Extra
    // -----------------------
    public function getExtra(string $field = ''): mixed
    {
        if ($this->extra === null || $field === '') {
            return [];
        }
        $tabExtra = json_decode($this->extra, true);
        return $tabExtra[$field] ?? '';
    }

    public function isComplete(): bool
    {
        return ($this->getField(Field::INCOMPLET) ?? 0) === 0;
    }
}
