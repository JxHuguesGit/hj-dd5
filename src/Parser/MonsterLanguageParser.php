<?php
namespace src\Parser;

use src\Constant\Field;
use src\Entity\RpgMonster;
use src\Entity\RpgMonsterLanguage as EntityRpgMonsterLanguage;
use src\Enum\LanguageEnum;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Repository\RpgMonsterLanguage as RepositoryRpgMonsterLanguage;
use src\Repository\RpgLanguage as RepositoryRpgLanguage;

class MonsterLanguageParser
{
    const PATTERN_SEPARATOR = "/[,;]/";

    public static function parseLanguages(RpgMonster $rpgMonster, \DOMDocument $dom): void
    {
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();

        $xpath = new \DOMXPath($dom);
        $nodes = $xpath->query("//strong[normalize-space(text())='Languages']");
        $node = $nodes->item(0);
        $nextNode = $node->nextSibling;
        $content = trim($nextNode->textContent);

        if ($content=='') {
            return;
        }

        $objDao = new RepositoryRpgLanguage($queryBuilder, $queryExecutor);
        $objDaoJoin = new RepositoryRpgMonsterLanguage($queryBuilder, $queryExecutor);
        $rpgMonsterId = $rpgMonster->getField(Field::ID);

        $elements = preg_split(self::PATTERN_SEPARATOR, $content);
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
            if ($enum===null) {
                return;
            }

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
                $obj = new EntityRpgMonsterLanguage(...$params);
                $objDaoJoin->insert($obj);
            }
        }
    }
}
