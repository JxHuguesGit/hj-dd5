<?php
namespace src\Action;

use src\Constant\Field as F;
use src\Entity\RpgMonster as EntityRpgMonster;
use src\Parser\RpgMonster as ParserRpgMonster;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Repository\RpgMonster;
use src\Utils\Session;

class MonsterCard
{
    const HTML_EXTENSION = '.html';

    public static function build(): string
    {
        $uktag = Session::fromPost('uktag');

        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $objDao = new RpgMonster($queryBuilder, $queryExecutor);

        if (substr($uktag, 0, 3)=='id-') {
            /** @var EntityRpgMonster $rpgMonster */
            $rpgMonster = $objDao->find(substr($uktag, 3));
            if ($rpgMonster->getField(F::INCOMPLET)==1) {
                $urlLocale = '../wp-content/plugins/hj-dd5/assets/aidedd/'.$rpgMonster->getField(F::UKTAG).self::HTML_EXTENSION;
                $content = file_get_contents($urlLocale);

                $dom = new \DOMDocument();
                libxml_use_internal_errors(true);
                $dom->loadHTML($content);

                ParserRpgMonster::parse($rpgMonster, $dom);
            }
            return $rpgMonster->getController()->getMonsterCard();
        } elseif (substr($uktag, 0, 3)=='fr-') {
            $uktag = substr($uktag, 3);
            $rpgMonsters = $objDao->findBy([F::FRTAG=>$uktag]);
            $urlDistant = 'https://www.aidedd.org/monster/fr/' . $uktag;
            $urlLocale = '../wp-content/plugins/hj-dd5/assets/aidedd/fr-'.$uktag.self::HTML_EXTENSION;
        } else {
            $rpgMonsters = $objDao->findBy([F::UKTAG=>$uktag]);
            $urlDistant = 'https://www.aidedd.org/monster/' . $uktag;
            $urlLocale = '../wp-content/plugins/hj-dd5/assets/aidedd/'.$uktag.self::HTML_EXTENSION;
        }
        $content = file_get_contents($urlDistant);
        file_put_contents($urlLocale, $content);

        if ($rpgMonsters->valid()) {
            $rpgMonster = $rpgMonsters->current();
            $blnComplete = $rpgMonster->getField(F::INCOMPLET)==0;
            if ($blnComplete) {
                $returned = $rpgMonster->getController()->getMonsterCard();
            } else {
                $content = file_get_contents($urlLocale);
                if (strpos($content, 'This monster does not exist.')!==false) {
                    $returned = 'Le monstre avec le tag '.$uktag.' ('.$urlDistant.') ne correspond à aucun fichier distant.';
                } else {
                    $dom = new \DOMDocument();
                    libxml_use_internal_errors(true);
                    $dom->loadHTML($content);
                    $body = $dom->getElementsByTagName('body')->item(0);
                    $returned = $dom->saveHTML($body);

                    ParserRpgMonster::parse($rpgMonster, $dom);
                }
            }
        } else {
            $returned = 'Tag non valide';
        }
        return $returned;
    }

}
