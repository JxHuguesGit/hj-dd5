<?php
namespace src\Parser;

use src\Constant\Field;
use src\Entity\RpgMonster as EntityRpgMonster;
use src\Entity\RpgMonsterCondition as EntityRpgMonsterCondition;
use src\Entity\RpgMonsterResistance as EntityRpgMonsterResistance;
use src\Entity\RpgMonsterSkill as EntityRpgMonsterSkill;
use src\Enum\ConditionEnum;
use src\Enum\DamageEnum;
use src\Enum\SkillEnum;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Repository\RpgCondition as RepositoryRpgCondition;
use src\Repository\RpgMonster as RepositoryRpgMonster;
use src\Repository\RpgMonsterCondition as RepositoryRpgMonsterCondition;
use src\Repository\RpgMonsterResistance as RepositoryRpgMonsterResistance;
use src\Repository\RpgMonsterSkill as RepositoryRpgMonsterSkill;
use src\Repository\RpgSkill as RepositoryRpgSkill;
use src\Repository\RpgTypeDamage as RepositoryRpgTypeDamage;
use src\Utils\Utils;
use \DomDocument;

class RpgMonster
{
    const PATTERN_SEPARATOR = "/[,;]/";

    private EntityRpgMonster $rpgMonster;
    private DOMDocument $dom;
    private QueryBuilder $queryBuilder;
    private QueryExecutor $queryExecutor;
    
    public function __construct($rpgMonster, $dom)
    {
        $this->rpgMonster = $rpgMonster;
        $this->dom = $dom;
    }
    
    public function parseDom(): void
    {
        $blnHasChanged = false;

        $this->queryBuilder  = new QueryBuilder();
        $this->queryExecutor = new QueryExecutor();
        
        // Déclaration des Dao

        $blnHasChanged |= $this->parseHitDice();
        $blnHasChanged |= MonsterSpeedParser::parse($this->rpgMonster, $this->dom);
        $blnHasChanged |= MonsterCaracsParser::parse($this->rpgMonster, $this->dom);
        $blnHasChanged |= $this->parseCrBm();
        $blnHasChanged |= $this->parseInitiative();
        $blnHasChanged |= MonsterSensesParser::parse($this->rpgMonster, $this->dom);

        MonsterLanguageParser::parse($this->rpgMonster, $this->dom);
        $this->parseSkills();
        $this->parseResistances();
        $this->parseImmunities();
        MonsterActionsParser::parse($this->rpgMonster, $this->dom);

        if ($this->rpgMonster->getField(Field::EXTRA) === '') {
            $this->rpgMonster->setField(Field::EXTRA, json_encode([], JSON_UNESCAPED_UNICODE));
            $blnHasChanged = true;
        }
        
        if ($blnHasChanged) {
            $objDao = new RepositoryRpgMonster($this->queryBuilder, $this->queryExecutor);
            $objDao->update($this->rpgMonster);
        }
    }
    
    
    
    

    
    





    private function parseInitiative(): bool
    {
        $blnHasChanged = false;
        
        $xpath = new \DOMXPath($this->dom);
        $nodes = $xpath->query("//strong[normalize-space(text())='Initiative']");
        if ($nodes->length === 0) {
            return false;
        }

        $node = $nodes->item(0);
        $next = $node->nextSibling;
        $value = trim($next->textContent);
        list($score,) = explode(' ', $value);
        $score = str_replace('+', '', $score);
        
        $stored = $this->rpgMonster->getField(Field::INITIATIVE);
        if ($stored!=$score) {
            $this->rpgMonster->setField(Field::INITIATIVE, $score);
            $blnHasChanged = true;
        }
                
        return $blnHasChanged;
    }

    private function parseCrBm(): bool
    {
        $blnHasChanged = false;
        
        $xpath = new \DOMXPath($this->dom);
        $nodes = $xpath->query("//strong[normalize-space(text())='CR']");
        if ($nodes->length === 0) {
            return false;
        }
        
        $crNode = $nodes->item(0);
        $nextNode = $crNode->nextSibling;
        $crValue = trim($nextNode->textContent);
        
        if (preg_match('/(.*) \(.*PB \+(\d*)/', $crValue, $matches)) {
            $cr = Utils::getUnformatCr($matches[1]);
            $stored = $this->rpgMonster->getField(Field::SCORECR);
            if ($stored!=$cr) {
                $this->rpgMonster->setField(Field::SCORECR, $cr);
                $blnHasChanged = true;
            }
        
            $pb = $matches[2];
            $stored = $this->rpgMonster->getField(Field::PROFBONUS);
            if ($stored!=$pb) {
                $this->rpgMonster->setField(Field::PROFBONUS, $pb);
                $blnHasChanged = true;
            }
        }
                
        return $blnHasChanged;
    }
    
    private function parseHitDice(): bool
    {
        $blnHasChanged = false;
        
        $xpath = new \DOMXPath($this->dom);
        $nodes = $xpath->query("//strong[normalize-space(text())='HP']");
        if ($nodes->length === 0) {
            return false;
        }
        
        $hpNode = $nodes->item(0);
        $nextNode = $hpNode->nextSibling;
        $hpValue = trim($nextNode->textContent);
        
        if (preg_match('/\(([^)]+)\)/', $hpValue, $matches)) {
            $value = '('.$matches[1].')';
            $tabExtra = json_decode($this->rpgMonster->getField(Field::EXTRA), true) ?: [];
            $stored = $tabExtra['hp'] ?? null;
        
            if ($stored!==$value) {
                $tabExtra['hp'] = $value;
                $json = json_encode($tabExtra, JSON_UNESCAPED_UNICODE);
                $this->rpgMonster->setField(Field::EXTRA, $json);
                $blnHasChanged = true;
            }
        }
                
        return $blnHasChanged;
    }
    
    private function parseSkills(): void
    {
        $xpath = new \DOMXPath($this->dom);
        $nodes = $xpath->query("//strong[normalize-space(text())='Skills']");
        $skillsNode = $nodes->item(0);
        $nextNode = $skillsNode->nextSibling;
        $skillsList = trim($nextNode->textContent);
        $tabSkills = explode(',', $skillsList);
        
        $objDao = new RepositoryRpgSkill($this->queryBuilder, $this->queryExecutor);
        $objDaoJoin = new RepositoryRpgMonsterSkill($this->queryBuilder, $this->queryExecutor);
        $rpgMonsterId = $this->rpgMonster->getField(Field::ID);
        
        if (!empty($tabSkills)) {
            foreach ($tabSkills as $str) {
                $pos = strpos($str, '+');
                $skill = trim(substr($str, 0, $pos-1));
                $value = trim(substr($str, $pos));
                $value = str_replace('+', '', $value);

                $enum = SkillEnum::fromEnglish($skill);
                if ($enum==null) {
                    continue;
                }
                $objs = $objDao->findBy([Field::NAME=>$enum->label()]);
                $obj = $objs->current();
                $skillId = $obj->getField(Field::ID);

                $params = [Field::MONSTERID=>$rpgMonsterId, Field::SKILLID=>$skillId];
                $objs = $objDaoJoin->findBy($params);

                if ($objs->isEmpty()) {
                    $params[Field::ID] = 0;
                    $params[Field::VALUE] = $value;
                    $obj = new EntityRpgMonsterSkill(...$params);
                    $objDaoJoin->insert($obj);
                } else {
                    $obj = $objs->current();
                    $stored = $obj->getField(Field::VALUE);
                    if ($stored!=$value) {
                        $obj->setField(Field::VALUE, $value);
                        $objDaoJoin->update($obj);
                    }
                }
            }
        }
    }

    private function parseResistances(): void
    {
        $xpath = new \DOMXPath($this->dom);
        $nodes = $xpath->query("//strong[normalize-space(text())='Resistances']");
        $node = $nodes->item(0);
        $nextNode = $node->nextSibling;
        $content = trim($nextNode->textContent);
        
        if ($content=='') {
            return;
        }
        
        $objDao = new RepositoryRpgTypeDamage($this->queryBuilder, $this->queryExecutor);
        $objDaoJoin = new RepositoryRpgMonsterResistance($this->queryBuilder, $this->queryExecutor);
        $rpgMonsterId = $this->rpgMonster->getField(Field::ID);
        
        $elements = preg_split(self::PATTERN_SEPARATOR, $content);
        foreach ($elements as $element) {
            $enum = DamageEnum::fromEnglish($element);
            
            if ($enum!=null) {
                // On va faire la recherche dans les dégâts.
                $objs = $objDao->findBy([Field::NAME=>$enum->label()]);
                $obj = $objs->current();
                $typeDamageId = $obj->getField(Field::ID);

                $params = [Field::MONSTERID=>$rpgMonsterId, Field::TYPEDMGID=>$typeDamageId, Field::TYPERESID=>'R'];
                $objs = $objDaoJoin->findBy($params);

                if ($objs->isEmpty()) {
                    $params[Field::ID] = 0;
                    $obj = new EntityRpgMonsterResistance(...$params);
                    $objDaoJoin->insert($obj);
                }
            }
        }
    }

    private function parseImmunities(): void
    {
        $xpath = new \DOMXPath($this->dom);
        $nodes = $xpath->query("//strong[normalize-space(text())='Immunities']");
        $node = $nodes->item(0);
        $nextNode = $node->nextSibling;
        $content = trim($nextNode->textContent);
        
        if ($content=='') {
            return;
        }
        
        $objDao = new RepositoryRpgTypeDamage($this->queryBuilder, $this->queryExecutor);
        $objDaoJoin = new RepositoryRpgMonsterResistance($this->queryBuilder, $this->queryExecutor);
        $objDaoCond = new RepositoryRpgCondition($this->queryBuilder, $this->queryExecutor);
        $objDaoJoinCond = new RepositoryRpgMonsterCondition($this->queryBuilder, $this->queryExecutor);
        $rpgMonsterId = $this->rpgMonster->getField(Field::ID);
        
        $elements = preg_split(self::PATTERN_SEPARATOR, $content);
        foreach ($elements as $element) {
            $enum = DamageEnum::fromEnglish($element);
            if ($enum!=null) {
                // On va faire la recherche dans les dégâts.
                $objs = $objDao->findBy([Field::NAME=>$enum->label()]);
                $obj = $objs->current();
                $typeDamageId = $obj->getField(Field::ID);

                $params = [Field::MONSTERID=>$rpgMonsterId, Field::TYPEDMGID=>$typeDamageId, Field::TYPERESID=>'I'];
                $objs = $objDaoJoin->findBy($params);

                if ($objs->isEmpty()) {
                    $params[Field::ID] = 0;
                    $obj = new EntityRpgMonsterResistance(...$params);
                    $objDaoJoin->insert($obj);
                }
            } else {
                $enum = ConditionEnum::fromEnglish($element);
                if ($enum!=null) {
                    $objs = $objDaoCond->findBy([Field::NAME=>$enum->label()]);
                    $obj = $objs->current();

                    $typeConditionId = $obj->getField(Field::ID);
                    $params = [Field::MONSTERID=>$rpgMonsterId, Field::CONDITIONID=>$typeConditionId];
                    $objs = $objDaoJoinCond->findBy($params);

                    if ($objs->isEmpty()) {
                        $params[Field::ID] = 0;
                        $obj = new EntityRpgMonsterCondition(...$params);
                        $objDaoJoinCond->insert($obj);
                    }
                }
            }
        }
    }


}
