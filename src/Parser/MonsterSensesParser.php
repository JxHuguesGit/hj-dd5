<?php
namespace src\Parser;

use src\Constant\Field;
use src\Entity\RpgMonster;
use src\Entity\RpgMonsterTypeVision as EntityRpgMonsterTypeVision;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Repository\RpgMonsterTypeVision as RepositoryRpgMonsterTypeVision;
use src\Repository\RpgTypeVision as RepositoryRpgTypeVision;

class MonsterSensesParser
{

    public static function parseSenses(RpgMonster &$rpgMonster, \DOMDocument $dom): bool
    {
        $hasChanged = false;
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $objDao = new RepositoryRpgTypeVision($queryBuilder, $queryExecutor);
        $objDaoJoin = new RepositoryRpgMonsterTypeVision($queryBuilder, $queryExecutor);
        
        $xpath = new \DOMXPath($dom);
        $nodes = $xpath->query("//strong[normalize-space(text())='Senses']");
        $node = $nodes->item(0);
        $nextNode = $node->nextSibling;
        $content = trim($nextNode->textContent);

        if ($content=='') {
            return $hasChanged;
        }

        $elements = explode(',', $content);
        foreach ($elements as $element) {
            $changed = static::parseSens($element, $rpgMonster, $objDao, $objDaoJoin);
            if ($changed) {
                $hasChanged = true;
            }
        }

        return $hasChanged;
    }

    public static function parseSens(string $element, RpgMonster &$rpgMonster, RepositoryRpgTypeVision $objDao, RepositoryRpgMonsterTypeVision $objDaoJoin): bool
    {
        $hasChanged = false;
        $rpgMonsterId = $rpgMonster->getField(Field::ID);

            $tab = explode(' ', trim($element));
            
            if ($tab[2]!='ft.') {
                if ($rpgMonster->getField(Field::PERCPASSIVE)!=$tab[2]) {
                    $rpgMonster->setField(Field::PERCPASSIVE, $tab[2]);
                    $hasChanged = true;
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
                    $obj = new EntityRpgMonsterTypeVision(...$params);
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
        return $hasChanged;
    }
        
}
