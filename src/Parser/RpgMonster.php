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
        $blnHasChanged |= MonsterSpeedParser::parseSpeed($this->rpgMonster, $this->dom);
        $blnHasChanged |= $this->parseCaracsPhysiques();
        $blnHasChanged |= $this->parseCaracsMentales();
        $blnHasChanged |= $this->parseCrBm();
        $blnHasChanged |= $this->parseInitiative();
        $blnHasChanged |= MonsterSensesParser::parseSenses($this->rpgMonster, $this->dom);

        MonsterLanguageParser::parseLanguages($this->rpgMonster, $this->dom);
        $this->parseSkills();
        $this->parseResistances();
        $this->parseImmunities();
        MonsterActionsParser::parseActions($this->rpgMonster, $this->dom);

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

    private function parseCaracsPhysiques(): bool
    {
        $blnHasChanged = false;
        
        $xpath = new \DOMXPath($this->dom);
        $nodes = $xpath->query("//div[contains(@class, 'car2') or contains(@class, 'car3')]");
        $values = [];
        foreach ($nodes as $node) {
            $values[] = trim($node->textContent);
        }
        // Normalement, il y a 9 valeurs
        if (count($values)!=9) {
            return $blnHasChanged;
        }
        
        $extra = $this->rpgMonster->getField(Field::EXTRA);
        $json = json_decode($extra, true);
        
        // 0 : score de force
        // 1 : bonus aux jets de carac de force
        // 2 : bonus aux jets de sauvegarde de force
        // 3 : score de dextérité
        // 4 & 5 : idem 1 & 2 pour la dextérité
        // 6 : score de constitution
        // 7 & 8 : idem 1 & 2 pour la constitution
        
        // Score de Force
        $score = $this->rpgMonster->getField(Field::STRSCORE);
        $value = $values[0];
        if ($score!=$value) {
            $this->rpgMonster->setField(Field::STRSCORE, $value);
            $blnHasChanged = true;
        }
        $mod = Utils::getModAbility($value);
        $value = str_replace(['+', '–'], ['', '-'], $values[1]);
        if ($mod!=$value) {
            $json['carstr'] = $value-$mod;
            $blnHasChanged = true;
        }
        $value = str_replace(['+', '–'], ['', '-'], $values[2]);
        if ($mod!=$value) {
            $json['jsstr'] = $value-$mod;
            $blnHasChanged = true;
        }
        
        // Score de Dextérité
        $score = $this->rpgMonster->getField(Field::DEXSCORE);
        $value = $values[3];
        if ($score!=$value) {
            $this->rpgMonster->setField(Field::DEXSCORE, $value);
            $blnHasChanged = true;
        }
        $mod = Utils::getModAbility($value);
        $value = str_replace(['+', '–'], ['', '-'], $values[4]);
        if ($mod!=$value) {
            $json['cardex'] = $value-$mod;
            $blnHasChanged = true;
        }
        $value = str_replace(['+', '–'], ['', '-'], $values[5]);
        if ($mod!=$value) {
            $json['jsdex'] = $value-$mod;
            $blnHasChanged = true;
        }
        
        // Score de Constitution
        $score = $this->rpgMonster->getField(Field::CONSCORE);
        $value = $values[6];
        if ($score!=$value) {
            $this->rpgMonster->setField(Field::CONSCORE, $value);
            $blnHasChanged = true;
        }
        $mod = Utils::getModAbility($value);
        $value = str_replace(['+', '–'], ['', '-'], $values[7]);
        if ($mod!=$value) {
            $json['carcon'] = $value-$mod;
            $blnHasChanged = true;
        }
        $value = str_replace(['+', '–'], ['', '-'], $values[8]);
        if ($mod!=$value) {
            $json['jscon'] = $value-$mod;
            $blnHasChanged = true;
        }
        
        $extra = json_encode($json, JSON_UNESCAPED_UNICODE);
        $this->rpgMonster->setField(Field::EXTRA, $extra);
                
        return $blnHasChanged;
    }

    private function parseCaracsMentales(): bool
    {
        $blnHasChanged = false;
        
        $xpath = new \DOMXPath($this->dom);
        $nodes = $xpath->query("//div[contains(@class, 'car5') or contains(@class, 'car6')]");
        $values = [];
        foreach ($nodes as $node) {
            $values[] = trim($node->textContent);
        }
        // Normalement, il y a 9 valeurs
        if (count($values)!=9) {
            return $blnHasChanged;
        }
        
        $extra = $this->rpgMonster->getField(Field::EXTRA);
        $json = json_decode($extra, true);
                
        // 0 : score de intelligence
        // 1 : bonus aux jets de carac de intelligence
        // 2 : bonus aux jets de sauvegarde de intelligence
        // 3 : score de sagesse
        // 4 & 5 : idem 1 & 2 pour la sagesse
        // 6 : score de charisme
        // 7 & 8 : idem 1 & 2 pour la charisme
        
        // Score de Intelligence
        $score = $this->rpgMonster->getField(Field::INTSCORE);
        $value = $values[0];
        if ($score!=$value) {
            $this->rpgMonster->setField(Field::INTSCORE, $value);
            $blnHasChanged = true;
        }
        $mod = Utils::getModAbility($value);
        $value = str_replace(['+', '–'], ['', '-'], $values[1]);
        if ($mod!=$value) {
            $json['carint'] = $value-$mod;
            $blnHasChanged = true;
        }
        $value = str_replace(['+', '–'], ['', '-'], $values[2]);
        if ($mod!=$value) {
            $json['jsint'] = $value-$mod;
            $blnHasChanged = true;
        }
        
        // Score de Sagesse
        $score = $this->rpgMonster->getField(Field::WISSCORE);
        $value = $values[3];
        if ($score!=$value) {
            $this->rpgMonster->setField(Field::WISSCORE, $value);
            $blnHasChanged = true;
        }
        $mod = Utils::getModAbility($value);
        $value = str_replace(['+', '–'], ['', '-'], $values[4]);
        if ($mod!=$value) {
            $json['carwis'] = $value-$mod;
            $blnHasChanged = true;
        }
        $value = str_replace(['+', '–'], ['', '-'], $values[5]);
        if ($mod!=$value) {
            $json['jswis'] = $value-$mod;
            $blnHasChanged = true;
        }
        
        // Score de Charisme
        $score = $this->rpgMonster->getField(Field::CHASCORE);
        $value = $values[6];
        if ($score!=$value) {
            $this->rpgMonster->setField(Field::CHASCORE, $value);
            $blnHasChanged = true;
        }
        $mod = Utils::getModAbility($value);
        $value = str_replace(['+', '–'], ['', '-'], $values[7]);
        if ($mod!=$value) {
            $json['carcha'] = $value-$mod;
            $blnHasChanged = true;
        }
        $value = str_replace(['+', '–'], ['', '-'], $values[8]);
        if ($mod!=$value) {
            $json['jscha'] = $value-$mod;
            $blnHasChanged = true;
        }
        
        $extra = json_encode($json, JSON_UNESCAPED_UNICODE);
        $this->rpgMonster->setField(Field::EXTRA, $extra);
                
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
