<?php
namespace src\Helper;

use src\Constant\Field;
use src\Entity\RpgJoinMonsterLanguage as EntityRpgJoinMonsterLanguage;
use src\Entity\RpgJoinMonsterTypeSpeed as EntityRpgJoinMonsterTypeSpeed;
use src\Entity\RpgJoinMonsterTypeVision as EntityRpgJoinMonsterTypeVision;
use src\Entity\RpgMonster;
use src\Entity\RpgMonsterAbility as EntityRpgMonsterAbility;
use src\Entity\RpgMonsterResistance as EntityRpgMonsterResistance;
use src\Entity\RpgMonsterSkill as EntityRpgMonsterSkill;
use src\Enum\DamageEnum;
use src\Enum\LanguageEnum;
use src\Enum\SkillEnum;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Repository\RpgJoinMonsterLanguage as RepositoryRpgJoinMonsterLanguage;
use src\Repository\RpgJoinMonsterTypeSpeed as RepositoryRpgJoinMonsterTypeSpeed;
use src\Repository\RpgJoinMonsterTypeVision as RepositoryRpgJoinMonsterTypeVision;
use src\Repository\RpgLanguage as RepositoryRpgLanguage;
use src\Repository\RpgMonster as RepositoryRpgMonster;
use src\Repository\RpgMonsterAbility as RepositoryRpgMonsterAbility;
use src\Repository\RpgMonsterResistance as RepositoryRpgMonsterResistance;
use src\Repository\RpgMonsterSkill as RepositoryRpgMonsterSkill;
use src\Repository\RpgSkill as RepositoryRpgSkill;
use src\Repository\RpgTypeDamage as RepositoryRpgTypeDamage;
use src\Repository\RpgTypeSpeed as RepositoryRpgTypeSpeed;
use src\Repository\RpgTypeVision as RepositoryRpgTypeVision;
use src\Utils\Utils;
use \DomDocument;

class RpgMonsterParser
{
	private RpgMonster $rpgMonster;
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
        $daoSenses = new RepositoryRpgTypeVision($this->queryBuilder, $this->queryExecutor);
        $daoJoinSenses = new RepositoryRpgJoinMonsterTypeVision($this->queryBuilder, $this->queryExecutor);
        $daoAbilities = new RepositoryRpgMonsterAbility($this->queryBuilder, $this->queryExecutor);

        $xpath = new \DOMXPath($this->dom);

		$blnHasChanged |= $this->parseHitDice();
        $blnHasChanged |= $this->parseSpeed();
        $blnHasChanged |= $this->parseCaracsPhysiques();
        $blnHasChanged |= $this->parseCaracsMentales();
        $blnHasChanged |= $this->parseCrBm();
        $blnHasChanged |= $this->parseSenses($daoSenses, $daoJoinSenses);

        $this->parseLanguages();
        $this->parseSkills();
        $this->parseResistances();
        $this->parseTraits($daoAbilities);
        $this->parseActions($daoAbilities);
        $this->parseBonusActions($daoAbilities);

        if ($this->rpgMonster->getField(Field::EXTRA) === '') {
        	$this->rpgMonster->setField(Field::EXTRA, json_encode([], JSON_UNESCAPED_UNICODE));
            $blnHasChanged = true;
        }
        
        if ($blnHasChanged) {
            $objDao = new RepositoryRpgMonster($this->queryBuilder, $this->queryExecutor);
        	$objDao->update($this->rpgMonster);
        }
    }
    
    private function parseActions($objDao): void
    {
        $xpath = new \DOMXPath($this->dom);
        $nodes = $xpath->query("//div[@class='rub' and normalize-space()='Actions']");
        $node = $nodes->item(0);

        if ($node=='') {
        	return;
        }

        $this->parseTraitAction('A', $node, $objDao);
    }
    
    private function parseTraits($objDao): void
    {
        $xpath = new \DOMXPath($this->dom);
        $nodes = $xpath->query("//div[@class='rub' and normalize-space()='Traits']");
        $node = $nodes->item(0);

        if ($node=='') {
        	return;
        }

        $this->parseTraitAction('T', $node, $objDao);
    }
    
    private function parseBonusActions($objDao): void
    {
        $xpath = new \DOMXPath($this->dom);
        $nodes = $xpath->query("//div[@class='rub' and normalize-space()='Bonus actions']");
        $node = $nodes->item(0);

        if ($node=='') {
        	return;        }

        $this->parseTraitAction('B', $node, $objDao);
    }
    
    private function parseTraitAction($typeId, $node, $objDao): void
    {
    	$actionPs = [];
        $current  = $node->nextSibling;
        $pattern = "/<p><strong><em>([^<]+)<\/em><\/strong>\. (.+)<\/p>/s";
        $rpgMonsterId = $this->rpgMonster->getField(Field::ID);
        
        while ($current) {
            // Ignorer les textes vides et les espaces
            if ($current->nodeType === XML_TEXT_NODE && trim($current->textContent) === '') {
                $current = $current->nextSibling;
                continue;
            }

            // Si on tombe sur un autre <div class="rub">, on arrête
            if (
                $current->nodeType === XML_ELEMENT_NODE &&
                $current->nodeName === 'div' &&
                $current->getAttribute('class') === 'rub'
            ) {
                break;
            }

            // Si c’est un <p>, on le garde
            if ($current->nodeType === XML_ELEMENT_NODE && $current->nodeName === 'p') {
                if (preg_match($pattern, trim($this->dom->saveHTML($current)), $matches)) {
			        $params = [
                    	Field::TYPEID=>$typeId,
                        Field::MONSTERID=>$rpgMonsterId,
                        Field::NAME => $matches[1],
                    ];
                    $objs = $objDao->findBy($params);
                    
                    if ($objs->isEmpty()) {
                    	$params[Field::ID] = 0;
                        $params[Field::DESCRIPTION] = $matches[2];
                        $obj = new EntityRpgMonsterAbility(...$params);
                        $objDao->insert($obj);
                    }                    
                }
            }

            $current  = $current ->nextSibling;
        }
        return;
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
        
        if (preg_match('/PB \+([0-9]*)/', $crValue, $matches)) {
	        $value = $matches[1];
        
            $stored = $this->rpgMonster->getField(Field::PROFBONUS);
            if ($stored!=$value) {
                $this->rpgMonster->setField(Field::PROFBONUS, $value);
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
    
    private function parseSpeed(): bool
    {
    	$blnHasChanged = false;
        
        $xpath = new \DOMXPath($this->dom);
        $nodes = $xpath->query("//strong[normalize-space(text())='Speed']");
        if ($nodes->length === 0) {
            return false;
        }
        
        $speedNode = $nodes->item(0);
        $nextNode = $speedNode->nextSibling;
        $speedValue = trim($nextNode->textContent);
        // 20 ft., Burrow 5 ft.
        $tabSpeed = explode (',', $speedValue);
        $standard = str_replace(' ft.', '', $tabSpeed[0])*3/10;
        $stored = $this->rpgMonster->getField(Field::VITESSE);
        if ($stored!=$standard) {
            $this->rpgMonster->setField(Field::VITESSE, $standard);
            $blnHasChanged = true;
        }
        
        // On gère les vitesses spéciales
        $objDaoTS = new RepositoryRpgTypeSpeed($this->queryBuilder, $this->queryExecutor);
        $objDaoJMTS = new RepositoryRpgJoinMonsterTypeSpeed($this->queryBuilder, $this->queryExecutor);
        
        for ($i=1; $i<count($tabSpeed); $i++) {
        	$tab = explode(' ', trim($tabSpeed[$i]));
            // $tab[0] : Burrow
            // $tab[1] : 5
            
            // Première étape, interroger rpgTypeSpeed pour récupérer l'id
            $objs = $objDaoTS->findBy([Field::UKTAG=>strtolower($tab[0])]);
            $obj = $objs->current();
            $typeSpeedId = $obj->getField(Field::ID);

			// Deuxième étape, interroger rpgMonsterSpeed pour vérifier si l'info est présente
            $rpgMonsterId = $this->rpgMonster->getField(Field::ID);
            $objs = $objDaoJMTS->findBy([Field::MONSTERID=>$rpgMonsterId, Field::TYPESPEEDID=>$typeSpeedId]);
            $value = $tab[1]*3/10;
            
            // Troisième étape, a : si elle est présente est identique, on ne fait rien
            // 					b : si elle est présente est différente, on la met à jour
            // 					c : si elle n'est pas présente on l'insère
            if ($objs->isEmpty()) {
            	$extra = json_encode('', JSON_UNESCAPED_UNICODE);
            	$params = [0, $rpgMonsterId, $typeSpeedId, $value, $extra];
            	$obj = new EntityRpgJoinMonsterTypeSpeed(...$params);
                $objDaoJMTS->insert($obj);
            } else {
	            $obj = $objs->current();
	            $stored = $obj->getField(Field::VALUE);
                if ($stored!=$value) {
                	$obj->setField(Field::VALUE, $value);
                    $objDaoJMTS->update($obj);
                }
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
        if ($score!=$values[0]) {
        	$this->rpgMonster->setField(Field::STRSCORE, $values[0]);
            $blnHasChanged = true;
            
            $mod = Utils::getModAbility($score);
            if ($mod!=$values[1]) {
                // TODO : Modifier Extra en fonction de $mod vis à vis de $values[1]
                //echo "Force Mod TODO<br>";
            }
            if ($mod!=$values[2]) {
                // TODO : Modifier Extra en fonction de $mod vis à vis de $values[2]
                //echo "Force JS TODO<br>";
            }
        }
        
        // Score de Dextérité        
        $score = $this->rpgMonster->getField(Field::DEXSCORE);
        if ($score!=$values[3]) {
        	$this->rpgMonster->setField(Field::DEXSCORE, $values[3]);
            $blnHasChanged = true;
        }
        $mod = Utils::getModAbility($score);
        if ($mod!=$values[4]) {
            // TODO : Modifier Extra en fonction de $mod vis à vis de $values[4]
            //echo "Dextérité Mod TODO<br>";
        }
        $value = strpos($values[5], '+')=== false ? $values[5] : substr($values[5], 1);
        if ($mod!=$value) {
            $json['jsdex'] = $value-$mod;
            $blnHasChanged = true;
        }
        
        // Score de Constitution        
        $score = $this->rpgMonster->getField(Field::CONSCORE);
        if ($score!=$values[6]) {
        	$this->rpgMonster->setField(Field::CONSCORE, $values[6]);
            $blnHasChanged = true;
            
            $mod = Utils::getModAbility($score);
            if ($mod!=$values[7]) {
                // TODO : Modifier Extra en fonction de $mod vis à vis de $values[7]
                //echo "Constitution Mod TODO<br>";
            }
            if ($mod!=$values[8]) {
                // TODO : Modifier Extra en fonction de $mod vis à vis de $values[8]
                //echo "Constitution JS TODO<br>";
            }
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
        if ($score!=$values[0]) {
        	$this->rpgMonster->setField(Field::INTSCORE, $values[0]);
            $blnHasChanged = true;
        }
        $mod = Utils::getModAbility($score);
        if ($mod!=$values[1]) {
        	// TODO : Modifier Extra en fonction de $mod vis à vis de $values[1]
            //echo "Intelligence Mod TODO : $mod - $values[1]<br>";
        }
        $value = strpos($values[2], '+')=== false ? $values[2] : substr($values[2], 1);
        if ($mod!=$value) {
            $json['jsint'] = $value-$mod;
            $blnHasChanged = true;
        }
        
        // Score de Sagesse        
        $score = $this->rpgMonster->getField(Field::WISSCORE);
        if ($score!=$values[3]) {
        	$this->rpgMonster->setField(Field::WISSCORE, $values[3]);
            $blnHasChanged = true;
        }
        $mod = Utils::getModAbility($score);
        if ($mod!=$values[4]) {
        	// TODO : Modifier Extra en fonction de $mod vis à vis de $values[4]
            //echo "Sagesse Mod TODO<br>";
        }
        if ($mod!=$values[5]) {
        	// TODO : Modifier Extra en fonction de $mod vis à vis de $values[5]
            //echo "Sagesse JS TODO<br>";
        }
        
        // Score de Charisme        
        $score = $this->rpgMonster->getField(Field::CHASCORE);
        if ($score!=$values[6]) {
        	$this->rpgMonster->setField(Field::CHASCORE, $values[6]);
            $blnHasChanged = true;
        }
        $mod = Utils::getModAbility($score);
        if ($mod!=$values[7]) {
        	// TODO : Modifier Extra en fonction de $mod vis à vis de $values[7]
            //echo "Charisme Mod TODO<br>";
        }
        if ($mod!=$values[8]) {
        	// TODO : Modifier Extra en fonction de $mod vis à vis de $values[8]
            //echo "Charisme JS TODO<br>";
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

    private function parseSenses($objDao, $objDaoJoin): bool
    {
    	$blnHasChanged = false;
        
        $xpath = new \DOMXPath($this->dom);
        $nodes = $xpath->query("//strong[normalize-space(text())='Senses']");
        $node = $nodes->item(0);
        $nextNode = $node->nextSibling;
		$content = trim($nextNode->textContent);

        if ($content=='') {
        	return $blnHasChanged;
        }

        $rpgMonsterId = $this->rpgMonster->getField(Field::ID);

        $elements = explode(',', $content);
        foreach ($elements as $element) {
        	$tab = explode(' ', trim($element));
            
            if ($tab[2]!='ft.') {
            	if ($this->rpgMonster->getField(Field::PERCPASSIVE)!=$tab[2]) {
                	$this->rpgMonster->setField(Field::PERCPASSIVE, $tab[2]);
                    $blnHasChanged = true;
                }
            } else {
            	$value = $tab[1]*3/10;
                $sens = $tab[0];
	            $objs = $objDao->findBy([Field::UKTAG=>$sens]);
                $obj = $objs->current();
                $sensId = $obj->getField(Field::ID);
                
                $params = [Field::MONSTERID=>$rpgMonsterId, Field::TYPEVISIONID=>$sensId];
                $objs = $objDaoJoin->findBy($params);

                if ($objs->isEmpty()) {
                    $params[Field::ID] = 0;
                    $params[Field::VALUE] = $value;
                    $params[Field::EXTRA] = json_encode([], JSON_UNESCAPED_UNICODE);
                    $obj = new EntityRpgJoinMonsterTypeVision(...$params);
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

        return $blnHasChanged;
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
        
        $elements = preg_split("/[,;]/", $content);
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
            } else {
	            //$enum = DamageEnum::fromEnglish($element);
            }
        }
    }
    
    private function parseLanguages(): void
    {
        $xpath = new \DOMXPath($this->dom);
        $nodes = $xpath->query("//strong[normalize-space(text())='Languages']");
        $node = $nodes->item(0);
        $nextNode = $node->nextSibling;
		$content = trim($nextNode->textContent);

        if ($content=='') {
        	return;
        }

        $objDao = new RepositoryRpgLanguage($this->queryBuilder, $this->queryExecutor);
        $objDaoJoin = new RepositoryRpgJoinMonsterLanguage($this->queryBuilder, $this->queryExecutor);
        $rpgMonsterId = $this->rpgMonster->getField(Field::ID);

        $elements = explode(',', $content);
        foreach ($elements as $element) {
            $enum = LanguageEnum::fromEnglish($element);
            // Si on $enum vaut null, la donnée ne doit pas exister en base.
            // A traiter.
            if ($enum==null) {
            	return;
            }
        
            $objs = $objDao->findBy([Field::NAME=>$enum->label()]);
            $obj = $objs->current();
            $languageId = $obj->getField(Field::ID);
        
			$params = [Field::MONSTERID=>$rpgMonsterId, Field::LANGUAGEID=>$languageId];
			$objs = $objDaoJoin->findBy($params);
            
			if ($objs->isEmpty()) {
				$params[Field::ID] = 0;
				$obj = new EntityRpgJoinMonsterLanguage(...$params);
				$objDaoJoin->insert($obj);
			}
        }
    }
    

}