<?php
namespace src\Controller;

use src\Collection\Collection;
use src\Constant\Constant;
use src\Constant\Field;
use src\Constant\Template;
use src\Entity\RpgAlignement as EntityRpgAlignement;
use src\Entity\RpgMonster as EntityRpgMonster;
use src\Entity\RpgReference as EntityRpgReference;
use src\Entity\RpgSousTypeMonstre as EntityRpgSousTypeMonstre;
use src\Entity\RpgTypeMonstre as EntityRpgTypeMonstre;
use src\Helper\SizeHelper;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Repository\RpgAlignement;
use src\Repository\RpgMonster as RepositoryRpgMonster;
use src\Repository\RpgReference;
use src\Repository\RpgSousTypeMonstre;
use src\Repository\RpgTypeMonstre;
use src\Utils\Table;

class AdminCompendiumPage extends AdminPage
{
    private string $bgColor = '';
    private string $fontColor = '';
    private array $defaultColor = [];
    
    public function getAdminContentPage(string $content=''): string
    {
        $currentId = $this->getArrParams('id');

        switch ($currentId) {
            case Constant::ARMORS :
                $objTable = RpgArmor::getTable();
            break;
            case Constant::WEAPONS :
                $objTable = RpgWeapon::getTable($this->arrParams);
            break;
            case Constant::SKILLS :
                $objTable = RpgSkill::getTable($this->arrParams);
            break;
            case Constant::MONSTERS :
                $objTable = RpgMonster::getTable($this->arrParams);
            break;
            case Constant::FEATS :
                $objTable = RpgFeat::getTable($this->arrParams);
               break;
            default :
                $objTable = null;
            break;
        }
        
        /*
        // Ici, on va gérer l'affichage de la feuille de personnage.
        // On va utiliser des personnages Mock.
        $mockHero = new MockHero();
        $hero = $mockHero->getHero();

        $scheme = 'ct-scheme-lightblue';
        $this->bgColor = '#FEFEFE';
        $this->fontColor = '#53a5c5';
        $this->defaultColor = [
            $this->bgColor, // Couleur de fond
            $this->fontColor, // Couleur de contour
        ];
        */
        // Dans cette méthode, on gère l'entête, le cadre noir : Image, couleurs, nom, espèce, classe, niveau
        // Tout le reste sera géré via d'autres méthodes afin de ne pas être perdu dans le nombre de paramètres du template
        $attributes = [
            $objTable?->display(),//$this->getBlockQuickInfo(), // bloc des données chiffrées
            '-large',//$hero->getId(), // id du personnage
            '',//$scheme, // style couleur (qui va définir les contours et fonds des svg mais aussi la couleur du texte)
            '',//'/wp-cotent/plugins/hj-dd5/assets/images/PJ1avatar.jpeg', // image du personnage
            '',//'Sheilas', // nom du personnage
            '',//'Humaine', // espèce du personnage
            '',//'Roublard 1', // classe du personnage
            '',//'Niveau 1', // niveau du personnage
            '',//$this->getBlockSubsections(), // bloc des données chiffrées
        ];

        $content .= $this->getRender(Template::ADMINCOMPENDIUM, $attributes);
        return parent::getAdminContentPage($content);
    }

    private function parseFileSource(Table &$objTable): void
    {
        // On ouvre le fichier monstres.html pour mettre à jour de façon automatique les différentes tables associées aux monstres
        // A terme, on pourra envisager de commenter ce morceau de code.
        // De plus, pour le moment on affiche le tableau à partir des données du fichier uniquement
        $handle = fopen(PLUGINS_DD5.'assets/data/monstres.html', 'r');
        $pattern = "/^.*<a href=\"(.*)\" t.*>(.*)<\/a>.*>([^>]*)<\/td>.*colT.*>([^>]*)<\/td>.*colD.*>([^>]*)<\/td>.*colP.*>([^>]*)<\/td>.*colP.*>([^>]*)<\/td>.*colQ.*>([^>]*)<\/td>.*colA.*>([^>]*)<\/td>.*colL.*>([^>]*)<\/td>.*colH.*>([^>]*)<\/td>.*colS.*>([^>]*)<\/td>.*$/";
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        // Gestion des références
        $objDaoReference = new RpgReference($queryBuilder, $queryExecutor);
        // Gestion des alignements
        $objDaoAlignement = new RpgAlignement($queryBuilder, $queryExecutor);
        // Gestion des types de monstres
        $objDaoTypeMonstre = new RpgTypeMonstre($queryBuilder, $queryExecutor);
        $objDaoSubTypeMonstre = new RpgSousTypeMonstre($queryBuilder, $queryExecutor);
        // Gestion des monstres
        $objDaoMonstre = new RepositoryRpgMonster($queryBuilder, $queryExecutor);
        //////////
        while (true) {
            $line = fgets($handle, 2048);
            if ($line===false) {
                break;
            }
            if (preg_match($pattern, $line, $matches)) {
                $attributes = [];
                $blnIncomplete = strpos($line, 'class="incomplet"')!==false;

                $attributes['id'] = 0;
                $attributes['name'] = $matches[2];
                $attributes['frTag'] = strpos($line, 'class="trad">FR')!==false ? 'oui' : 'non';
                $attributes['ukTag'] = $matches[1];
                $attributes['incomplet'] = $blnIncomplete;

                // Le CR
                $strCr = trim($matches[3]);
                switch ($strCr) {
                    case 'None' :
                        $floatCr = -1;
                    break;
                    case '1/8' :
                        $floatCr = 0.125;
                    break;
                    case '1/4' :
                        $floatCr = 0.25;
                    break;
                    case '1/2' :
                        $floatCr = 0.5;
                    break;
                    default :
                        $floatCr = (float)$strCr;
                    break;
                }
                $attributes['cr'] = $floatCr;

                // Le type du monstre
                $strMonstreType = trim($matches[4]);
                $strMonstreSubType = '';
                $strpos = strpos($strMonstreType, '(');
                if ($strpos!==false) {
                    $strMonstreSubType = substr($strMonstreType, $strpos+1, -1);
                    $strMonstreType = trim(substr($strMonstreType, 0, $strpos-1));
                } else {
                    $strMonstreSubType = '';
                }

                // Possiblement, on est dans le cas "Celestial (or Fey) or Fiend"
                if ($strMonstreType=='Celestial or Fey or Fiend') {
                    $strMonstreType = 'CelFeyFie';
                } elseif ($strMonstreType=='Celestial or Fiend') {
                    $strMonstreType = 'CelFie';
                }

                // On peut aussi être dans le cas de nuées...
                if (substr($strMonstreType, 0, 5)=='Swarm') {
                    list(, , $swarmSize, $strMonstreType) = explode(' ', $strMonstreType);
                    $strSwarm = SizeHelper::parse($swarmSize);
                    switch ($strMonstreType) {
                        case 'Beasts' :
                            $strMonstreType = 'Beast';
                        break;
                        case 'Fiends' :
                            $strMonstreType = 'Fiend';
                        break;
                        case 'Monstrosities' :
                            $strMonstreType = 'Monstrosity';
                        break;
                        default :
                        break;
                    }
                } else {
                    $strSwarm = 0;
                }

                // On doit insérer le type de monstre s'il n'existe pas
                $objsTypeMonstre = $objDaoTypeMonstre->findBy([Field::NAME=>$strMonstreType]);
                if (!$objsTypeMonstre->valid()) {
                    // A priori, ici, le Type de Monstre n'existe pas. On va donc l'insérer.
                    $objTypeMonstre = new EntityRpgTypeMonstre(0, $strMonstreType);
                    $objDaoTypeMonstre->insert($objTypeMonstre);
                } else {
                    $objTypeMonstre = $objsTypeMonstre->current();
                }
                $idTypeMonstre = $objTypeMonstre->getId();
                // Puis on doit insérer le sous-type de monstre s'il n'existe pas pour ce type de monstre
                if ($strMonstreSubType!='') {
                    $objsSousTypeMonstre = $objDaoSubTypeMonstre->findBy([Field::NAME=>$strMonstreSubType, Field::MSTTYPEID=>$idTypeMonstre]);
                    if (!$objsSousTypeMonstre->valid()) {
                        // A priori, ici, le Type de Monstre n'existe pas. On va donc l'insérer.
                        $objSousTypeMonstre = new EntityRpgSousTypeMonstre(0, $idTypeMonstre, $strMonstreSubType);
                        $objDaoSubTypeMonstre->insert($objSousTypeMonstre);
                    } else {
                        $objSousTypeMonstre = $objsSousTypeMonstre->current();
                    }
                    $idSousTypeMonstre = $objSousTypeMonstre->getId();
                } else {
                    $idSousTypeMonstre = 0;
                }
                $attributes['monstreTypeId'] = $idTypeMonstre;
                $attributes['monsterSubTypeId'] = $idSousTypeMonstre??0;
                $attributes['swarmSize'] = $strSwarm;

                // La taille du monstre
                $strSize = $matches[5];
                $bitmask = SizeHelper::parse($strSize);
                $attributes['monsterSize'] = $bitmask;

                // La CA
                $scoreCA = $matches[6];
                $attributes['ca'] = $scoreCA;

                // Les points de vie
                $totalHP = $matches[7];
                $attributes['hp'] = $totalHP;

                // Les vitesses hors marche
                $strVitesse = trim($matches[8]);
                if ($strVitesse!='') {

                }

                // L'alignement du monstre a-t-il une entrée dans la table rpgAlignement ?
                $strAlignement = $matches[9];
                $objsAlignement = $objDaoAlignement->findBy([Field::NAME=>$strAlignement]);
                if (!$objsAlignement->valid()) {
                    // A priori, ici, l'Alignement n'existe pas. On va donc l'insérer.
                    $objAlignement = new EntityRpgAlignement(0, $strAlignement);
                    $objDaoAlignement->insert($objAlignement);
                } else {
                    $objAlignement = $objsAlignement->current();
                }
                $idAlignement = $objAlignement->getId();
                //////////////////////////////////////////////////////////////////////////////
                $attributes['alignmentId'] = $idAlignement;

                // Le statut Légendaire
                $blnLegendary = $matches[10]=='Legendary';
                $attributes['legendary'] = $blnLegendary;

                // Habitat
                $strHabitat = $matches[11];
                $attributes['habitat'] = $strHabitat;

                // La référence du monstre a-t-elle une entrée dans la table rpgReference ?
                $strReference = $matches[12];
                $objsReference = $objDaoReference->findBy([Field::NAME=>$strReference]);
                if (!$objsReference->valid()) {
                    // A priori, ici, la Référence n'existe pas. On va donc l'insérer.
                    $objReference = new EntityRpgReference(0, $strReference);
                    $objDaoReference->insert($objReference);
                } else {
                    $objReference = $objsReference->current();
                }
                $idReference = $objReference->getId();
                $attributes['referenceId'] = $idReference;
                //////////////////////////////////////////////////////////////////////////////

                // On va vérifier si le monstre existe en base ou non.
                $objsMonstre = $objDaoMonstre->findBy([Field::UKTAG=>$attributes['ukTag']]);
                if (!$objsMonstre->valid()) {
                    // Le monstre n'existe pas, on va le créer.
                    $objMonstre = new EntityRpgMonster(...$attributes);
                    $objDaoMonstre->insert($objMonstre);
                }
                //////////////////////////////////////////////////////////////////////////////
            }
        }
        ///////////////////////////////////////////
    }

}
