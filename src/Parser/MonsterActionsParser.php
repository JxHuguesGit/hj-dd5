<?php
namespace src\Parser;

use src\Constant\Field;
use src\Entity\RpgMonster;
use src\Entity\RpgMonsterAbility as EntityRpgMonsterAbility;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Repository\RpgMonsterAbility as RepositoryRpgMonsterAbility;

class MonsterActionsParser
{
    public static function parseActions(RpgMonster $rpgMonster, \DOMDocument $dom)
    {
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $objDao = new RepositoryRpgMonsterAbility($queryBuilder, $queryExecutor);

        $xpath = new \DOMXPath($dom);

        $nodes = $xpath->query("//div[@class='rub' and normalize-space()='Actions']");
        $node = $nodes->item(0);
        if ($node!='') {
            static::parseTraitAction('A', $rpgMonster, $dom, $node, $objDao);
        }

        $nodes = $xpath->query("//div[@class='rub' and normalize-space()='Traits']");
        $node = $nodes->item(0);
        if ($node!='') {
            static::parseTraitAction('T', $rpgMonster, $dom, $node, $objDao);
        }

        $nodes = $xpath->query("//div[@class='rub' and normalize-space()='Bonus actions']");
        $node = $nodes->item(0);
        if ($node!='') {
            static::parseTraitAction('B', $rpgMonster, $dom, $node, $objDao);
        }

        $nodes = $xpath->query("//div[@class='rub' and normalize-space()='Reactions']");
        $node = $nodes->item(0);
        if ($node!='') {
            static::parseTraitAction('R', $rpgMonster, $dom, $node, $objDao);
        }

        $nodes = $xpath->query("//div[@class='rub' and normalize-space()='Legendary actions']");
        $node = $nodes->item(0);
        if ($node!='') {
            static::parseTraitAction('L', $rpgMonster, $dom, $node, $objDao);
        }
    }

    public static function parseTraitAction(string $typeId, RpgMonster $rpgMonster, \DOMDocument $dom, $node, RepositoryRpgMonsterAbility $objDao)
    {
        $current  = $node->nextSibling;
        $pattern = "/<p><strong><em>([^<]+)<\/em><\/strong>\. (.+)<\/p>/s";
        $rpgMonsterId = $rpgMonster->getField(Field::ID);
        
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
            if ($current->nodeType === XML_ELEMENT_NODE
                && $current->nodeName === 'p'
                && preg_match($pattern, trim($dom->saveHTML($current)), $matches)) {
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
                    $raw .= $dom->saveHTML($scan);
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

}
