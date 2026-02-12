<?php
namespace src\Controller;

use src\Constant\Bootstrap;
use src\Constant\Constant;
use src\Constant\Field;
use src\Constant\Template;
use src\Entity\RpgHeros;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Repository\RpgClasse as RepositoryRpgClasse;
use src\Repository\RpgHerosFeat as RepositoryRpgHerosFeat;
use src\Repository\RpgOrigin as RepositoryRpgOrigin;
use src\Repository\RpgSpecies as RepositoryRpgSpecies;
use src\Repository\RpgFeat as RepositoryRpgFeat;
use src\Utils\Session;

class AdminCharacterCreationPage extends AdminPage
{
    public function __construct(array $params=[])
    {
        $this->arrParams = $params;
    }

    public function getAdminContentPage(string $content=''): string
    {
        // On est sur une étape de création d'un personnage.
        // Dans quelle étape sommes-nous ?
        // Soit on a un paramètre "step" dans GET
        // Soit on vient de valider une étape de formulaire, il faut donc s'appuyer sur une valeur présente dans POST
        $rpgHero = $this->arrParams['rpgHero'];
        $attributes = [];
        $urlTemplate = '';

        $step = Session::fromGet('step', $rpgHero->getField(Field::CREATESTEP));


        switch ($step) {
            case 'classe' :
                $this->getClasseInterface($rpgHero, $attributes, $urlTemplate);
            break;
            case 'originFeat' :
                $this->getOriginFeatInterface($rpgHero, $attributes, $urlTemplate);
            break;
            case Constant::SPECIES :
                $this->getSpeciesInterface($rpgHero, $attributes, $urlTemplate);
            break;
            case Constant::ORIGIN :
                $this->getOriginInterface($rpgHero, $attributes, $urlTemplate);
            break;
            case Constant::CST_NAME :
            default :
                $this->getNameInterface($rpgHero, $attributes, $urlTemplate);
            break;
        }

        $attributes = [
            $this->getRender($urlTemplate, $attributes),
            '',
        ];

        return parent::getAdminContentPage($this->getRender(Template::ADMINCOMPENDIUM, $attributes));
    }

    private function getSideBarCreation(RpgHeros $rpgHero): string
    {
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $objDaoRHF = new RepositoryRpgHerosFeat($queryBuilder, $queryExecutor);
        $objsHeroFeat = $objDaoRHF->findBy([Field::HEROSID=>$rpgHero->getField(Field::ID)]);
        $objsHeroFeat->rewind();
        $feats = [];
        while ($objsHeroFeat->valid()) {
            $objHeroFeat = $objsHeroFeat->current();
            $feats[] = $objHeroFeat->getFullName();
            $objsHeroFeat->next();
        }
        
        $attributes = [
            '/wp-admin/admin.php?page=hj-dd5/admin_manage.php&onglet=character&id='.$rpgHero->getField(Field::ID).'&step=',
            $rpgHero->getField(Field::NAME),
            $rpgHero->getOrigin()?->getField(Field::NAME),
            $rpgHero->getSpecies()?->getFullName(),
            implode(', ', $feats),
            $rpgHero->getStrClasses(),
        ];

        return $this->getRender(Template::CREATE_SIDEBAR, $attributes);
    }

    private function getClasseInterface(RpgHeros $rpgHero, array &$attributes, string &$urlTemplate): void
    {
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $objDao = new RepositoryRpgClasse($queryBuilder, $queryExecutor);
        $objsClasse = $objDao->findAll([Field::NAME=>Constant::CST_ASC]);
        
        $checkedId = 0;
        $strRadios = '';
        $objsClasse->rewind();
        while ($objsClasse->valid()) {
            $obj = $objsClasse->current();
            $strRadios .= $obj->getController()->getRadioForm('characterClassId', $checkedId==$obj->getField(Field::ID));
            $objsClasse->next();
        }

        $attributes = [
            $this->getSideBarCreation($rpgHero),
            $rpgHero->getFIeld(Field::ID),
            $strRadios,
        ];
        $urlTemplate = Template::CREATE_CLASSE;
    }

    private function getOriginFeatInterface(RpgHeros $rpgHero, array &$attributes, string &$urlTemplate): void
    {
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $objDaoFeats = new RepositoryRpgFeat($queryBuilder, $queryExecutor);
        $rpgFeats = $objDaoFeats->findBy([Field::FEATTYPEID=>1], [Field::NAME=>Constant::CST_ASC]);

        // On va définir la sélection par défaut du radio bouton.
        // Soit on l'a déjà enregistrer et on la ressort par défaut
        // Soit on n'a rien enregistrer (1er passage) et on ressort le don attaché à l'origine.
        $secondFeatId = '';
        $objDaoRHF = new RepositoryRpgHerosFeat($queryBuilder, $queryExecutor);
        $objsHeroFeat = $objDaoRHF->findBy([Field::HEROSID=>$rpgHero->getField(Field::ID)]);
        $objsHeroFeat->rewind();
        switch ($objsHeroFeat->count()) {
            case 1 :
                $objHeroFeat = $objsHeroFeat->current();
                $checkedFeatId = $objHeroFeat->getField(Field::FEATID);
                $checkedExtraFeatId = $objHeroFeat->getField(Field::EXTRA);
            break;
            case 2 :
                $objHeroFeat = $objsHeroFeat->current();
                $checkedFeatId = $objHeroFeat->getField(Field::FEATID);
                $checkedExtraFeatId = $objHeroFeat->getField(Field::EXTRA);
                $objsHeroFeat->next();
                if ($objsHeroFeat->valid()) {
                    $objHeroFeat = $objsHeroFeat->current();
                    $secondFeatId = $objHeroFeat->getField(Field::FEATID);
                    $secondExtraFeatId = $objHeroFeat->getField(Field::EXTRA);
                }
            break;
            case 0 :
            default :
                // Aucun Feat accroché, au personnage, on doit récupérer celui associé à l'origine
                $objFeat = $rpgHero->getOrigin()->getOriginFeat();
                $checkedFeatId = $objFeat->getField(Field::ID);
            break;
        }

        $strRadios2 = '';
        $strRadios = '';
        $rpgFeats->rewind();
        // Construction de la liste des options d'origines avec sélection si donnée présente.
        while ($rpgFeats->valid()) {
            $rpgFeat = $rpgFeats->current();
            $strRadios .= $rpgFeat->getController()->getRadioForm('characterFeatId', $checkedFeatId==$rpgFeat->getField(Field::ID));
            if ($rpgHero->getField(Field::SPECIESID)==7) {
                $strRadios2 .= $rpgFeat->getController()->getRadioForm('secondFeatId', $secondFeatId==$rpgFeat->getField(Field::ID));
            }
            $rpgFeats->next();
        }

        $strExtraRadios2 = '';
        $strExtraRadios = '';
        $objDaoRpgClasse = new RepositoryRpgClasse($queryBuilder, $queryExecutor);
        $rpgClasses = $objDaoRpgClasse->findAll([Field::NAME=>Constant::CST_ASC]);
        $rpgClasses->rewind();
        while ($rpgClasses->valid()) {
            $rpgClasse = $rpgClasses->current();
            // Clerc, Druide et Magicien sont liés à "Initié à la magie"
            if (in_array($rpgClasse->getField(Field::ID), [3, 4, 7])) {
                $strExtraRadios .= $rpgClasse->getController()->getRadioForm('extraCharacterFeatId', $checkedExtraFeatId==$rpgClasse->getField(Field::ID));
                $strExtraRadios2 .= $rpgClasse->getController()->getRadioForm('extraSecondFeatId', $secondExtraFeatId==$rpgClasse->getField(Field::ID));
            }
            $rpgClasses->next();
        }

        $attributes = [
            $this->getSideBarCreation($rpgHero),
            $rpgHero->getFIeld(Field::ID),
            $strRadios,
            $rpgHero->getField(Field::SPECIESID)==7?'':' '.Bootstrap::CSS_DNONE,
            $strRadios2,
            $checkedFeatId==5?'':Bootstrap::CSS_DNONE,
            $checkedFeatId==5?$strExtraRadios:'',
            $secondFeatId==5?'':' '.Bootstrap::CSS_DNONE,
            $secondFeatId==5?$strExtraRadios2:'',
        ];
        $urlTemplate = Template::CREATE_FEAT;
    }

    private function getSpeciesInterface(RpgHeros $rpgHero, array &$attributes, string &$urlTemplate): void
    {
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $objDaoSpecies = new RepositoryRpgSpecies($queryBuilder, $queryExecutor);
        $rpgSpecies = $objDaoSpecies->findBy([Field::PARENTID=>0], [Field::NAME=>Constant::CST_ASC]);
        $selSpeciesId = $rpgHero->getFIeld(Field::SPECIESID);

        $strOptions = '';
        $strOptions2 = '';
        $rpgSpecies->rewind();
        // Construction de la liste des options d'origines avec sélection si donnée présente.
        while ($rpgSpecies->valid()) {
            $element = $rpgSpecies->current();
            $strOptions .= $element->getController()->getRadioForm($selSpeciesId==$element->getField(Field::ID));

            $rpgSubSpecies = $objDaoSpecies->findBy([Field::PARENTID=>$element->getField(Field::ID)], [Field::NAME=>Constant::CST_ASC]);
            $rpgSubSpecies->rewind();
            if ($rpgSubSpecies->isEmpty()) {
                $rpgSpecies->next();
                continue;
            }

            $strOptions2 .= '<div class="subspecies-group" data-species="'.$element->getField(Field::ID).'" style="display:none;">';
            $strOptions2 .= '<h5>'.$element->getField(Field::NAME).'</h5>';
            while ($rpgSubSpecies->valid()) {
                $element = $rpgSubSpecies->current();
                $strOptions2 .= $element->getController()->getRadioForm($selSpeciesId==$element->getField(Field::ID));
                $rpgSubSpecies->next();
            }
            $strOptions2 .= '</div>';

            $rpgSpecies->next();
        }

        $attributes = [
            $this->getSideBarCreation($rpgHero),
            $rpgHero->getFIeld(Field::ID),
            $strOptions,
            $strOptions2,
        ];
        $urlTemplate = Template::CREATE_SPECIES;
    }

    private function getOriginInterface(RpgHeros $rpgHero, array &$attributes, string &$urlTemplate): void
    {
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $objDaoOrigins = new RepositoryRpgOrigin($queryBuilder, $queryExecutor);
        $rpgOrigins = $objDaoOrigins->findAll([Field::NAME=>Constant::CST_ASC]);
        $selOriginId = $rpgHero->getFIeld(Field::ORIGINID);

        $strOptions = '';
        $rpgOrigins->rewind();
        // Construction de la liste des options d'origines avec sélection si donnée présente.
        while ($rpgOrigins->valid()) {
            $rpgOrigin = $rpgOrigins->current();
            $strOptions .= $rpgOrigin->getController()->getRadioForm($selOriginId==$rpgOrigin->getField(Field::ID));
            $rpgOrigins->next();
        }

        $attributes = [
            $this->getSideBarCreation($rpgHero),
            $rpgHero->getFIeld(Field::ID),
            $strOptions,
        ];
        $urlTemplate = Template::CREATE_ORIGIN;
    }

    private function getNameInterface(RpgHeros $rpgHero, array &$attributes, string &$urlTemplate): void
    {
        $attributes = [
            $this->getSideBarCreation($rpgHero),
            $rpgHero->getFIeld(Field::ID),
            $rpgHero->getField(Field::NAME),
            // Notes relatives au personnage. Pas encore implémentée
            '',
        ];
        $urlTemplate = Template::CREATE_NAME;
    }

}
