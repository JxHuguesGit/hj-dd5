<?php
namespace src\Action;

use src\Constant\Field;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Repository\RpgMonster;
use src\Utils\Session;

class MonsterCard
{
    public static function build(): string
    {
        $uktag = Session::fromPost('uktag');

		// On récupère le monstre en base, en s'appuyant sur son ukTag
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
		$objDao = new RpgMonster($queryBuilder, $queryExecutor);
        $rpgMonsters = $objDao->findBy([Field::UKTAG=>$uktag]);

		// On va aussi récupérer le html du monstre et le copier en local pour l'exploiter si besoin
        $urlSource = 'https://www.aidedd.org/monster/' . $uktag;
        $content = file_get_contents($urlSource);
        $urlDestination = '../wp-content/plugins/hj-dd5/assets/aidedd/'.$uktag.'.html';
        file_put_contents($urlDestination, $content);
        $blnFr = false;

		// Si le monstre est présent en base, on pourrait aussi récupérer le fichier en français s'il existe.
        // Voir parser les fichiers pour avoir les infos.
        // S'il n'existe pas... Bah, on ne peut pas être arrivé ici.
        if ($rpgMonsters->valid()) {
        	$rpgMonster = $rpgMonsters->current();
            $frTag = $rpgMonster->getField(Field::FRTAG);
            if ($frTag!='non') {
                $urlSource = 'https://www.aidedd.org/monster/fr/' . $frTag;
                $content = file_get_contents($urlSource);
                $urlDestination = '../wp-content/plugins/hj-dd5/assets/aidedd/fr-'.$frTag.'.html';
                file_put_contents($urlDestination, $content);
		        $blnFr = true;
            }
            if (!$rpgMonster->parseFile($urlDestination, $blnFr)) {
		        return $rpgMonster->getController()->getMonsterCard();
            } else {
            	return $rpgMonster->msgErreur;
            }
        } else {
        	return 'ukTag non valide';
        }
    }

}