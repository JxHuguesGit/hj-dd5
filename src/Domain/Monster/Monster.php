<?php
namespace src\Domain\Monster;

use src\Collection\Collection;
use src\Constant\Field as F;
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
        F::ID,
        F::FRNAME,
        F::NAME,
        F::FRTAG,
        F::UKTAG,
        F::INCOMPLET,
        F::SCORECR,
        F::MSTTYPEID,
        F::MSTSSTYPID,
        F::SWARMSIZE,
        F::MSTSIZE,
        F::ALGNID,
        F::SCORECA,
        F::SCOREHP,
        F::INITIATIVE,
        F::LEGENDARY,
        F::HABITAT,
        F::REFID,
        F::STRSCORE,
        F::DEXSCORE,
        F::CONSCORE,
        F::INTSCORE,
        F::WISSCORE,
        F::CHASCORE,
        F::PROFBONUS,
        F::PERCPASSIVE,
        F::EXTRA,

        F::TYPMSTNAME,
        F::ABBR,

        F::SSTYPMSTNAME,

        F::REFNAME,
    ];
    public const FIELD_TYPES = [
        F::FRNAME       => FieldType::STRING,
        F::NAME         => FieldType::STRING,
        F::FRTAG        => FieldType::STRING,
        F::UKTAG        => FieldType::STRING,
        F::INCOMPLET    => FieldType::INTNULLABLE,
        F::SCORECR      => FieldType::FLOAT,
        F::MSTTYPEID    => FieldType::INT,
        F::MSTSSTYPID   => FieldType::INTNULLABLE,
        F::SWARMSIZE    => FieldType::INTNULLABLE,
        F::MSTSIZE      => FieldType::INT,
        F::ALGNID       => FieldType::INT,
        F::SCORECA      => FieldType::INT,
        F::SCOREHP      => FieldType::INT,
        F::INITIATIVE   => FieldType::INT,
        F::LEGENDARY    => FieldType::INT,
        F::HABITAT      => FieldType::STRING,
        F::REFID        => FieldType::INT,
        F::STRSCORE     => FieldType::INT,
        F::DEXSCORE     => FieldType::INT,
        F::CONSCORE     => FieldType::INT,
        F::INTSCORE     => FieldType::INT,
        F::WISSCORE     => FieldType::INT,
        F::CHASCORE     => FieldType::INT,
        F::PROFBONUS    => FieldType::INT,
        F::PERCPASSIVE  => FieldType::INT,
        F::EXTRA        => FieldType::STRINGNULLABLE,

        F::TYPMSTNAME   => FieldType::STRING,
        F::ABBR         => FieldType::STRING,

        F::SSTYPMSTNAME => FieldType::STRINGNULLABLE,

        F::REFNAME      => FieldType::STRINGNULLABLE,
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
        return ($this->getField(F::INCOMPLET) ?? 0) === 0;
    }
}
