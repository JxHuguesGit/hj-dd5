<?php
namespace src\Action;

use src\Constant\Field;
use src\Entity\RpgMonster as EntityRpgMonster;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Repository\RpgMonster;
use src\Utils\Session;

class MonsterCard
{
    public static function build(): string
    {
        $uktag = Session::fromPost('uktag');

        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $objDao = new RpgMonster($queryBuilder, $queryExecutor);

        if (substr($uktag, 0, 3)=='id-') {
            /** @var EntityRpgMonster $rpgMonster */
            $rpgMonster = $objDao->find(substr($uktag, 3));
            return $rpgMonster->getController()->getMonsterCard();
        } elseif (substr($uktag, 0, 3)=='fr-') {
            $uktag = substr($uktag, 3);
            $rpgMonsters = $objDao->findBy([Field::FRTAG=>$uktag]);
            $urlDistant = 'https://www.aidedd.org/monster/fr/' . $uktag;
            $urlLocale = '../wp-content/plugins/hj-dd5/assets/aidedd/fr-'.$uktag.'.html';
        } else {
            $rpgMonsters = $objDao->findBy([Field::UKTAG=>$uktag]);
            $urlDistant = 'https://www.aidedd.org/monster/' . $uktag;
            $urlLocale = '../wp-content/plugins/hj-dd5/assets/aidedd/'.$uktag.'.html';
        }
        $content = file_get_contents($urlDistant);
        file_put_contents($urlLocale, $content);
        
        if ($rpgMonsters->valid()) {
            $rpgMonster = $rpgMonsters->current();
            $blnComplete = $rpgMonster->getField(Field::INCOMPLET)==0;
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
                }
            }
        } else {
            $returned = 'Tag non valide';
        }
        return $returned;
    }

}
