<?php
namespace src\Entity;

use src\Collection\Collection;
use src\Constant\Field;
use src\Controller\RpgMonster as ControllerRpgMonster;
use src\Factory\MonsterFactory as RpgMonsterFactory;
use src\Helper\SizeHelper;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Repository\RpgMonster as RepositoryRpgMonster;
use src\Repository\RpgMonsterAbility as RepositoryRpgMonsterAbility;
use src\Repository\RpgMonsterCondition as RepositoryRpgMonsterCondition;
use src\Repository\RpgMonsterResistance as RepositoryRpgMonsterResistance;
use src\Repository\RpgMonsterSkill as RepositoryRpgMonsterSkill;
use src\Repository\RpgMonsterLanguage as RepositoryRpgMonsterLanguage;
use src\Repository\RpgMonsterTypeSpeed as RepositoryRpgMonsterTypeSpeed;
use src\Repository\RpgMonsterTypeVision as RepositoryRpgMonsterTypeVision;
use src\Repository\RpgAlignement as RepositoryRpgAlignement;
use src\Repository\RpgReference as RepositoryRpgReference;
use src\Repository\RpgSousTypeMonstre as RepositoryRpgSousTypeMonstre;
use src\Repository\RpgTypeMonstre as RepositoryRpgTypeMonstre;
use src\Utils\Utils;

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
        Field::VITESSE,
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

    public string $msgErreur;
    
    protected CharacterStats $stats;
    protected MonsterAbilities $abilities;
    protected MonsterDefenses $defenses;

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

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Hydratation de stats depuis le même tableau
        $this->stats = new CharacterStats($attributes);
        $this->abilities = new MonsterAbilities($this->id);
        $this->defenses = new MonsterDefenses($this->id);
    }

    public static function factory(array $attributes): self
    {
        return RpgMonsterFactory::create($attributes);
    }
    
    public function getField(string $field)
    {
        // Premier niveau : propriétés de l'entité
        if (property_exists($this, $field)) {
            return $this->{$field};
        }
        
        if (isset($this->stats) && method_exists($this->stats, 'getField')) {
            try {
                return $this->stats->getField($field);
            } catch (\InvalidArgumentException $e) {
                // On continue pour lancer l'exception finale
            }
        }
    
        throw new \InvalidArgumentException("Le champ '$field' n'existe pas.");
    }

    public function setField(string $field, mixed $value): self
    {
        if (property_exists($this, $field)) {
            $this->{$field} = $value;
            return $this;
        }

        if (isset($this->stats) && method_exists($this->stats, 'setField')) {
            try {
                $this->stats->setField($field, $value);
                return $this;
            } catch (\InvalidArgumentException $e) {
                // continuer pour lancer exception finale
            }
        }

        throw new \InvalidArgumentException("Le champ '$field' n'existe pas.");
    }

    public function getController(): ControllerRpgMonster
    {
        $controller = new ControllerRpgMonster;
        $controller->setField(self::TABLE, $this);
        return $controller;
    }

    // Délégation CharacterStats
    
    // Délégation MonsterAbilities
    public function getTraits(): Collection
    {
        return $this->abilities->getTraits();
    }
    
    public function getActions(): Collection
    {
        return $this->abilities->getActions();
    }

    public function getBonusActions(): Collection
    {
        return $this->abilities->getBonusActions();
    }

    public function getReactions(): Collection
    {
        return $this->abilities->getReactions();
    }

    public function getLegendaryActions(): Collection
    {
        return $this->abilities->getLegendaryActions();
    }

    // Délégation MonsterDefenses
    public function getResistances(string $typeResistanceId): Collection
    {
        return $this->defenses->getResistances($typeResistanceId);
    }

    public function getConditions(): Collection
    {
        return $this->defenses->getConditions();
    }



    public function getSenses(): Collection
    {
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $objDao = new RepositoryRpgMonsterTypeVision($queryBuilder, $queryExecutor);
        $params = [Field::MONSTERID=>$this->id];
        return $objDao->findBy($params);
    }
    
    public function getSkills(): Collection
    {
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $objDao = new RepositoryRpgMonsterSkill($queryBuilder, $queryExecutor);
        $params = [Field::MONSTERID=>$this->id];
        return $objDao->findBy($params);
    }

    public function getLanguages(): Collection
    {
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $objDao = new RepositoryRpgMonsterLanguage($queryBuilder, $queryExecutor);
        $params = [Field::MONSTERID=>$this->id];
        return $objDao->findBy($params);
    }

    public function getAlignement(): ?RpgAlignement
    {
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $objDao = new RepositoryRpgAlignement($queryBuilder, $queryExecutor);
        return $objDao->find($this->alignmentId);
    }

    public function getReference(): ?RpgReference
    {
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $objDao = new RepositoryRpgReference($queryBuilder, $queryExecutor);
        return $objDao->find($this->referenceId);
    }
    
    
    
    
    public function getExtra($field=''): mixed
    {
        if ($this->extra==null || $field=='') {
            return [];
        }
        $tabExtra = json_decode($this->extra, true);
        return $tabExtra[$field]??'';
    }
    
    public function getStrExtra(string $field): string
    {
        $value = $this->{$field};
        $extra = $this->getExtra($field);
        if ($extra!='') {
            $value .= ' ' . $extra;
        }
        return $value;
    }
    
    public function getFormatCr(): string
    {
        switch ($this->cr) {
            case -1 :
                $returned = 'aucun';
            break;
            case 0.125 :
                $returned = '1/8';
            break;
            case 0.25 :
                $returned = '1/4';
            break;
            case 0.5 :
                $returned = '1/2';
            break;
            default :
                $returned = $this->cr;
            break;
        }
        return $returned;
    }
    
    public function getTotalXp(): string
    {
        $xpMap = [
            -1     => 0,
            0      => 10,
            0.125  => 25,
            0.25   => 50,
            0.5    => 100,
            1      => 200,
            2      => 450,
            3      => 700,
            4      => 1100,
            5      => 1800,
            6      => 2300,
            8      => 3900,
            9      => 5000,
            10     => 5900,
            14     => 11500,
            16     => 15000,
        ];
        $xp = $xpMap[$this->cr] ?? null;
        return $xp ? number_format($xp, 0, ',', ' ') : '??';
    }


    public function getStrName(): string
    {
        return $this->frName=='' ? $this->name : $this->frName;
    }

    public function getStrType(): string
    {
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        // Récupération du type de monstre (et de son genre pour accord en français)
        $objDao = new RepositoryRpgTypeMonstre($queryBuilder, $queryExecutor);
        /** @var RpgTypeMonstre $objTypeMonstre */
        $objTypeMonstre = $objDao->find($this->monstreTypeId);
        $gender = '';
        $strType = $objTypeMonstre->getStrName($gender);
        //////////////////////

        // Si le monstre est une nuée
        if ($this->swarmSize!=0) {
            $strType = 'Nuée de '.SizeHelper::toLabelFr($this->swarmSize, $gender).'s '.$strType.'s';
        }
        //////////////////////

        // Si le monstre a un sous-type
        if ($this->monsterSubTypeId!=0) {
            $objDao = new RepositoryRpgSousTypeMonstre($queryBuilder, $queryExecutor);
            /** @var RpgSousTypeMonstre $objSousTypeMonstre */
            $objSousTypeMonstre = $objDao->find($this->monsterSubTypeId);
            $strType .= ' ('.$objSousTypeMonstre->getStrName().')';
        }
        //////////////////////

        return $strType;
    }
    
    public function getSizeTypeAndAlignement(): string
    {
        $strSTAA  = $this->getStrType() . ' de taille ';
        $strSTAA .= SizeHelper::toLabelFr($this->monsterSize);
        $obj = $this->getAlignement();
        return $strSTAA.', '.$obj->getStrAlignement();
    }

    public function getScoreModifier(int $value): string
    {
        return ($value>=0 ? '+' : '').$value;
    }

    public function getStrModifier(int $value): string
    {
        return $this->getScoreModifier($value);
    }
        
    public function getStringScore(string $carac): string
    {
        if (in_array($carac, ['str', 'dex', 'con'])) {
            $score = $this->getField($carac.'Score');
            $modC = $this->getScoreModifier(Utils::getModAbility($score));
            $bonus = $this->getExtra('js'.$carac);
            if ($bonus=='') {
                $bonus = 0;
            }
            $modJdS = $this->getScoreModifier(Utils::getModAbility($score, $bonus));
            return "<div class='col car2'>$score</div><div class='col car3'>$modC</div><div class='col car3'>$modJdS</div>";
        } else {
            $score = $this->getField($carac.'Score');
            $modC = $this->getScoreModifier(Utils::getModAbility($score));
            $bonus = $this->getExtra('js'.$carac);
            if ($bonus=='') {
                $bonus = 0;
            }
            $modJdS = $this->getScoreModifier(Utils::getModAbility($score, $bonus));
            return "<div class='col car5'>$score</div><div class='col car6'>$modC</div><div class='col car6'>$modJdS</div>";
        }
    }
    
    public function getStrInitiative(): string
    {
        return ($this->initiative>=0 ? '+' : '').$this->initiative;
    }

    public function getStrVitesse(): string
    {
        $value = $this->vitesse.'m';
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();

        $objDao = new RepositoryRpgMonsterTypeSpeed($queryBuilder, $queryExecutor);
        /** @var RpgMonsterTypeSpeed $objRpgMonsterTypeSpeed */
        $objs = $objDao->findBy([Field::MONSTERID=>$this->id]);
        $objs->rewind();
        while ($objs->valid()) {
            $value .= ', ';
            $obj = $objs->current();
            $value .= $obj->getController()->getFormatString();
            $objs->next();
        }

        $extra = $this->getExtra('vitesse');
        if ($extra!='') {
            $value .= $extra;
        }
        return $value;
    }
    
}
