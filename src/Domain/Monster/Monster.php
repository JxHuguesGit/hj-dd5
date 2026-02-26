<?php
namespace src\Domain\Monster;

use src\Collection\Collection;
use src\Constant\Field;
use src\Constant\FieldType;
use src\Domain\Criteria\MonsterSpeedTypeCriteria;
use src\Domain\Entity;
use src\Domain\Entity\MonsterSpeedType as EntityMonsterSpeedType;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Repository\MonsterSpeedTypeRepository;
use src\Service\Domain\MonsterAbilitiesService;
use src\Service\Reader\MonsterSpeedTypeReader;

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

    // Service
    private ?MonsterAbilitiesService $services = null;
    // Relations 1-1
    private ?MonsterType $typeEntity           = null;
    private ?MonsterSubType $subTypeEntity     = null;
    private ?MonsterReference $referenceEntity = null;
    // Relations 1-N
    private ?Collection $speedTypeEntities = null;
    private ?Collection $traits            = null;
    private ?Collection $actions           = null;
    private ?Collection $bonusActions      = null;
    private ?Collection $reactions         = null;
    private ?Collection $legendaryActions  = null;
    private ?Collection $skills            = null;
    private ?Collection $conditions        = null;
    private ?Collection $resistances       = null;

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
        if (! in_array($field, self::FIELDS, true)) {
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
    // Façades 1-N
    // -------------------------------------------------
    public function speed(int $speedTypeId): ?EntityMonsterSpeedType
    {
        if ($this->speedTypeEntities === null) {
            $reader = new MonsterSpeedTypeReader(
                new MonsterSpeedTypeRepository(
                    new QueryBuilder(),
                    new QueryExecutor()
                )
            );
            $criteria                = new MonsterSpeedTypeCriteria();
            $criteria->monsterId     = $this->id;
            $this->speedTypeEntities = $reader->allMonsterSpeedTypes($criteria);
        }
        return $this->speedTypeEntities->find(fn($item) => $item->typeSpeedId === $speedTypeId) ?? null;
    }

    public function traits(): Collection
    {
        if ($this->traits === null) {
            if ($this->services === null) {
                $this->services = new MonsterAbilitiesService($this->id);
            }
            $this->traits = $this->services->getTraits();
        }
        return $this->traits;
    }

    public function actions(): Collection
    {
        if ($this->actions === null) {
            if ($this->services === null) {
                $this->services = new MonsterAbilitiesService($this->id);
            }
            $this->actions = $this->services->getActions();
        }
        return $this->actions;
    }

    public function bonusActions(): Collection
    {
        if ($this->bonusActions === null) {
            if ($this->services === null) {
                $this->services = new MonsterAbilitiesService($this->id);
            }
            $this->bonusActions = $this->services->getBonusActions();
        }
        return $this->bonusActions;
    }

    public function reactions(): Collection
    {
        if ($this->reactions === null) {
            if ($this->services === null) {
                $this->services = new MonsterAbilitiesService($this->id);
            }
            $this->reactions = $this->services->getReactions();
        }
        return $this->reactions;
    }

    public function legendaryActions(): Collection
    {
        if ($this->legendaryActions === null) {
            if ($this->services === null) {
                $this->services = new MonsterAbilitiesService($this->id);
            }
            $this->legendaryActions = $this->services->getLegendaryActions();
        }
        return $this->legendaryActions;
    }

    public function skills(): Collection
    {
        if ($this->skills === null) {
            if ($this->services === null) {
                $this->services = new MonsterAbilitiesService($this->id);
            }
            $this->skills = $this->services->getSkills();
        }
        return $this->skills;
    }

    public function conditions(): Collection
    {
        if ($this->conditions === null) {
            if ($this->services === null) {
                $this->services = new MonsterAbilitiesService($this->id);
            }
            $this->conditions = $this->services->getConditions();
        }
        return $this->conditions;
    }

    public function resistances(): Collection
    {
        if ($this->resistances === null) {
            if ($this->services === null) {
                $this->services = new MonsterAbilitiesService($this->id);
            }
            $this->resistances = $this->services->getResistances();
        }
        return $this->resistances;
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
