<?php
namespace src\Entity;

use src\Constant\Field;
use src\Controller\RpgMonster as ControllerRpgMonster;
use src\Factory\MonsterFactory as RpgMonsterFactory;
use src\Entity\CharacterStats;
use src\Service\Domain\MonsterAbilitiesService;
use src\Service\Domain\MonsterDefensesService;

class RpgMonster extends Entity
{
    public const TABLE = 'rpgMonster';
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
    ];

    // -----------------------
    // Propriétés
    // -----------------------
    public string $msgErreur;

    protected CharacterStats $stats;
    protected MonsterAbilitiesService $abilities;
    protected MonsterDefensesService $defenses;

    // Caractéristiques principales
    protected string $frName;
    protected string $name;
    protected string $frTag;
    protected string $ukTag;
    protected int $incomplet;
    protected float $cr;
    protected int $monstreTypeId;
    protected int $monsterSubTypeId;
    protected int $swarmSize;
    protected int $monsterSize;
    protected int $alignmentId;
    protected int $ca;
    protected float $vitesse;
    protected int $initiative;
    protected int $legendary;
    protected string $habitat;
    protected int $referenceId;
    protected ?string $extra;

    // Scores
    protected int $hp = 0;
    protected int $strScore = 0;
    protected int $dexScore = 0;
    protected int $conScore = 0;
    protected int $intScore = 0;
    protected int $wisScore = 0;
    protected int $chaScore = 0;
    protected int $profBonus = 0;
    protected int $percPassive = 0;

    // -----------------------
    // Constructeur
    // -----------------------
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->stats = new CharacterStats($this);
        $this->abilities = new MonsterAbilitiesService($this->id);
        $this->defenses = new MonsterDefensesService($this->id);
    }

    public function __get(string $field): mixed
    {
        if (property_exists($this, $field)) {
            return $this->$field;
        }
        return null;
    }

    // -----------------------
    // Factory
    // -----------------------
    public static function factory(array $attributes): self
    {
        return RpgMonsterFactory::create($attributes);
    }

    // -----------------------
    // Contrôleur
    // -----------------------
    public function getController(): ControllerRpgMonster
    {
        $controller = new ControllerRpgMonster;
        $controller->setField(self::TABLE, $this);
        return $controller;
    }

    // -----------------------
    // Accesseurs vers services
    // -----------------------
    public function getStats(): CharacterStats
    {
        return $this->stats;
    }

    public function getAbilities(): MonsterAbilitiesService
    {
        return $this->abilities;
    }

    public function getDefenses(): MonsterDefensesService
    {
        return $this->defenses;
    }

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
}
