<?php
namespace src\Helper;

use src\Constant\Field;
use src\Entity\RpgJoinMonsterLanguage as EntityRpgJoinMonsterLanguage;
use src\Entity\RpgJoinMonsterTypeSpeed as EntityRpgJoinMonsterTypeSpeed;
use src\Entity\RpgJoinMonsterTypeVision as EntityRpgJoinMonsterTypeVision;
use src\Entity\RpgMonster;
use src\Entity\RpgMonsterAbility as EntityRpgMonsterAbility;
use src\Entity\RpgMonsterCondition as EntityRpgMonsterCondition;
use src\Entity\RpgMonsterResistance as EntityRpgMonsterResistance;
use src\Entity\RpgMonsterSkill as EntityRpgMonsterSkill;
use src\Enum\ConditionEnum;
use src\Enum\DamageEnum;
use src\Enum\LanguageEnum;
use src\Enum\SkillEnum;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Repository\RpgCondition as RepositoryRpgCondition;
use src\Repository\RpgJoinMonsterLanguage as RepositoryRpgJoinMonsterLanguage;
use src\Repository\RpgJoinMonsterTypeSpeed as RepositoryRpgJoinMonsterTypeSpeed;
use src\Repository\RpgJoinMonsterTypeVision as RepositoryRpgJoinMonsterTypeVision;
use src\Repository\RpgLanguage as RepositoryRpgLanguage;
use src\Repository\RpgMonster as RepositoryRpgMonster;
use src\Repository\RpgMonsterAbility as RepositoryRpgMonsterAbility;
use src\Repository\RpgMonsterCondition as RepositoryRpgMonsterCondition;
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
        $blnHasChanged |= $this->parseInitiative();
        $blnHasChanged |= $this->parseSenses($daoSenses, $daoJoinSenses);

        $this->parseLanguages();
        $this->parseSkills();
        $this->parseResistances();
        $this->parseImmunities();
        $this->parseTraits($daoAbilities);
        $this->parseActions($daoAbilities);
        $this->parseBonusActions($daoAbilities);
        $this->parseReactions($daoAbilities);
        $this->parseLegendaryActions($daoAbilities);

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
    
    private function parseReactions($objDao): void
    {
        $xpath = new \DOMXPath($this->dom);
        $nodes = $xpath->query("//div[@class='rub' and normalize-space()='Reactions']");
        $node = $nodes->item(0);

        if ($node=='') {
            return;        }

        $this->parseTraitAction('R', $node, $objDao);
    }

    private function parseLegendaryActions($objDao): void
    {
        $xpath = new \DOMXPath($this->dom);
        $nodes = $xpath->query("//div[@class='rub' and normalize-space()='Legendary actions']");
        $node = $nodes->item(0);

        if ($node=='') {
            return;
        }

        $this->parseTraitAction('L', $node, $objDao);
    }
    
    private function parseTraitAction($typeId, $node, $objDao): void
    {
        $actionPs = [];
        $current  = $node->nextSibling;
        $pattern = "/<p><strong><em>([^<]+)<\/em><\/strong>\. (.+)<\/p>/s";
        $rpgMonsterId = $this->rpgMonster->getField(Field::ID);

        //echo "On recherche $typeId<br><br>";
        
        while ($current) {
            // Ignorer les textes vides et les espaces
            if ($current->nodeType === XML_TEXT_NODE && trim($current->textContent) === '') {
                $current = $current->nextSibling;
                continue;
            }

            //var_dump($current);
            //echo '<br><br>';

            // Si on tombe sur un autre <div class="rub">, on arrête
            if (
                $current->nodeType === XML_ELEMENT_NODE &&
                $current->nodeName === 'div' &&
                $current->getAttribute('class') === 'rub'
            ) {
                break;
            }

            if (
                $current->nodeType === XML_ELEMENT_NODE &&
                $current->nodeName === 'div' &&
                $current->getAttribute('class') === 'legend'
            ) {
                $legendText = trim($current->textContent);

                // Enregistrer un "header" spécial (optionnel)
                $params = [
                    Field::ID => 0,
                    Field::TYPEID => $typeId,
                    Field::MONSTERID => $rpgMonsterId,
                    Field::NAME => 'legend',
                    Field::DESCRIPTION => $legendText,
                ];
                $obj = new EntityRpgMonsterAbility(...$params);
                $objDao->insert($obj);

                // Puis continuer vers les <p> d’actions
                $current = $current->nextSibling;
                continue;
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
            
            // ?? Cas 2 : Texte brut + <br> (ex: Detect Life.<br>)
            if (
                $current->nodeType === XML_ELEMENT_NODE &&
                in_array($current->nodeName, ['br', 'text']) || $current->nodeType === XML_TEXT_NODE
            ) {
                // On récupère le HTML brut de tous les fragments jusqu'au prochain <div class="rub">
                $raw = '';
                $scan = $current;
                while ($scan && !(
                    $scan->nodeType === XML_ELEMENT_NODE &&
                    $scan->nodeName === 'div' &&
                    $scan->getAttribute('class') === 'rub'
                )) {
                    $raw .= $this->dom->saveHTML($scan);
                    $scan = $scan->nextSibling;
                }

                // Parser les lignes séparées par <br>
                $lines = preg_split('/<br\s*\/?>/i', $raw);
                foreach ($lines as $line) {
                    $line = trim(strip_tags($line));
                    if ($line === '') {
                        continue;
                       }

                    // Nettoyer le nom
                    $name = rtrim($line, '.');

                    // Vérifier si ce trait existe déjà
                    $params = [
                        Field::TYPEID => $typeId,
                        Field::MONSTERID => $rpgMonsterId,
                        Field::NAME => $name,
                    ];
                    $objs = $objDao->findBy($params);

                    if ($objs->isEmpty()) {
                        $params[Field::ID] = 0;
                        $params[Field::DESCRIPTION] = ''; // Pas de description dans ce format
                        $obj = new EntityRpgMonsterAbility(...$params);
                        $objDao->insert($obj);
                    }
                }

                // On saute tous les nœuds déjà lus
                $current = $scan;
                continue;
            }
            
            $current  = $current ->nextSibling;
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
        
        if (preg_match('/(.*) \(.*PB \+([0-9]*)/', $crValue, $matches)) {
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
            // $tab[3] : (hover)
            $extra = trim($tab[3]);
            
            // Première étape, interroger rpgTypeSpeed pour récupérer l'id
            $objs = $objDaoTS->findBy([Field::UKTAG=>strtolower($tab[0])]);
            $obj = $objs->current();
            $typeSpeedId = $obj->getField(Field::ID);

            // Deuxième étape, interroger rpgMonsterSpeed pour vérifier si l'info est présente
            $rpgMonsterId = $this->rpgMonster->getField(Field::ID);
            $objs = $objDaoJMTS->findBy([Field::MONSTERID=>$rpgMonsterId, Field::TYPESPEEDID=>$typeSpeedId]);
            $value = $tab[1]*3/10;
            
            // Troisième étape, a : si elle est présente est identique, on ne fait rien
            //                     b : si elle est présente est différente, on la met à jour
            //                     c : si elle n'est pas présente on l'insère
            if ($objs->isEmpty()) {
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
                $stored = $obj->getField(Field::EXTRA);
                if ($stored!=$extra) {
                    $obj->setField(Field::EXTRA, $extra);
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
        $value = $values[0];
        if ($score!=$value) {
            $this->rpgMonster->setField(Field::STRSCORE, $value);
            $blnHasChanged = true;
        }
        $mod = Utils::getModAbility($value);
        /*
        if ($mod!=$values[1]) {
            // TODO : Modifier Extra en fonction de $mod vis à vis de $values[1]
            //echo "Force Mod TODO<br>";
        }
        */
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
        /*
        if ($mod!=$values[4]) {
            // TODO : Modifier Extra en fonction de $mod vis à vis de $values[4]
            //echo "Dextérité Mod TODO<br>";
        }
        */
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
        /*
        if ($mod!=$values[7]) {
            // TODO : Modifier Extra en fonction de $mod vis à vis de $values[7]
            //echo "Constitution Mod TODO<br>";
        }
        */
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
        /*
        if ($mod!=$values[1]) {
            // TODO : Modifier Extra en fonction de $mod vis à vis de $values[1]
            //echo "Intelligence Mod TODO : $mod - $values[1]<br>";
        }
        */
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
        /*
        if ($mod!=$values[4]) {
            // TODO : Modifier Extra en fonction de $mod vis à vis de $values[4]
            //echo "Sagesse Mod TODO<br>";
        }
        */
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
        /*
        if ($mod!=$values[7]) {
            // TODO : Modifier Extra en fonction de $mod vis à vis de $values[7]
            //echo "Charisme Mod TODO<br>";
        }
        */
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
                    $params[Field::EXTRA] = '';
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
        
        $elements = preg_split("/[,;]/", $content);
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
                } else {
                    echo "[$element]";
                }
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

        $elements = preg_split("/[,;]/", $content);
        foreach ($elements as $element) {
            list($ability, $value, $test) = explode(' ', trim($element));
            if ($test=='ft.') {
                // Dans ce cas, value est une distance en pieds, on la convertit en mètres.
                $value = isset($value) ? 3*$value/10 : 0;
            } else {
                // Dans ce cas, on est sans doute dans un sous type de langues. Par exemple : Primordial (aérien).
                $ability .= ' ' . $value;
                $value = 0;
            }
            $enum = LanguageEnum::fromEnglish($ability);

            // Si on $enum vaut null, la donnée ne doit pas exister en base.
            // Ca peut être aussi parce qu'on a quelque chose comme : telepathy 120 ft.
            // A traiter.
            if ($enum!=null) {
                $objs = $objDao->findBy([Field::NAME=>$enum->label()]);
                $obj = $objs->current();
                if ($obj==null) {
                    echo "[".$enum->label()."]";
                }
                $languageId = $obj->getField(Field::ID);

                $params = [Field::MONSTERID=>$rpgMonsterId, Field::LANGUAGEID=>$languageId];
                $objs = $objDaoJoin->findBy($params);

                if ($objs->isEmpty()) {
                    $params[Field::ID] = 0;
                    $params[Field::VALUE] = $value;
                    $obj = new EntityRpgJoinMonsterLanguage(...$params);
                    $objDaoJoin->insert($obj);
                }
            }
        }
    }
    

}
