<?php
namespace src\Entity;

use src\Collection\Collection;
use src\Constant\Field;
use src\Controller\RpgMonster as ControllerRpgMonster;
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
    public string $msgErreur;

    public function __construct(
        protected int $id,
        protected string $frName,
        protected string $name,
        protected string $frTag,
        protected string $ukTag,
        protected int $incomplet,
        protected float $cr,
        protected int $monstreTypeId,
        protected int $monsterSubTypeId,
        protected int $swarmSize,
        protected int $monsterSize,
        protected int $alignmentId,
        protected int $ca,
        protected int $hp,
        protected float $vitesse,
        protected int $initiative,
        protected int $legendary,
        protected string $habitat,
        protected int $referenceId,
        protected int $strScore,
        protected int $dexScore,
        protected int $conScore,
        protected int $intScore,
        protected int $wisScore,
        protected int $chaScore,
        protected int $profBonus,
        protected int $percPassive,
        protected ?string $extra
    ) {

    }

    public function getController(): ControllerRpgMonster
    {
        $controller = new ControllerRpgMonster;
        $controller->setField('rpgMonster', $this);
        return $controller;
    }
    
    public function getTraits(): Collection
    {
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $objDao = new RepositoryRpgMonsterAbility($queryBuilder, $queryExecutor);
        $params = [Field::TYPEID=>'T', Field::MONSTERID=>$this->id];
        return $objDao->findBy($params, [Field::NAME=>'ASC']);
    }
    
    public function getActions(): Collection
    {
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $objDao = new RepositoryRpgMonsterAbility($queryBuilder, $queryExecutor);
        $params = [Field::TYPEID=>'A', Field::MONSTERID=>$this->id];
        return $objDao->findBy($params, [Field::NAME=>'ASC']);
    }
    
    public function getBonusActions(): Collection
    {
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $objDao = new RepositoryRpgMonsterAbility($queryBuilder, $queryExecutor);
        $params = [Field::TYPEID=>'B', Field::MONSTERID=>$this->id];
        return $objDao->findBy($params, [Field::NAME=>'ASC']);
    }

    public function getReactions(): Collection
    {
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $objDao = new RepositoryRpgMonsterAbility($queryBuilder, $queryExecutor);
        $params = [Field::TYPEID=>'R', Field::MONSTERID=>$this->id];
        return $objDao->findBy($params, [Field::NAME=>'ASC']);
    }

    public function getLegendaryActions(): Collection
    {
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $objDao = new RepositoryRpgMonsterAbility($queryBuilder, $queryExecutor);
        $params = [Field::TYPEID=>'L', Field::MONSTERID=>$this->id];
        return $objDao->findBy($params, [Field::NAME=>'ASC']);
    }

    public function getResistances(string $typeResistanceId): Collection
    {
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $objDao = new RepositoryRpgMonsterResistance($queryBuilder, $queryExecutor);
        $params = [Field::TYPERESID=>$typeResistanceId, Field::MONSTERID=>$this->id];
        $collection = $objDao->findBy($params);
        if ($typeResistanceId=='I') {
            $objDao = new RepositoryRpgMonsterCondition($queryBuilder, $queryExecutor);
            $params = [Field::MONSTERID=>$this->id];
            $collection->concat($objDao->findBy($params));
        }
        return $collection;
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
    
    public function getConditions(): Collection
    {
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $objDao = new RepositoryRpgMonsterCondition($queryBuilder, $queryExecutor);
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
            $score = $this->{$carac.'Score'};
            $modC = $this->getScoreModifier(Utils::getModAbility($score));
            $bonus = $this->getExtra('js'.$carac);
            if ($bonus=='') {
                $bonus = 0;
            }
            $modJdS = $this->getScoreModifier(Utils::getModAbility($score, $bonus));
            return "<div class='col car2'>$score</div><div class='col car3'>$modC</div><div class='col car3'>$modJdS</div>";
        } else {
            $score = $this->{$carac.'Score'};
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
