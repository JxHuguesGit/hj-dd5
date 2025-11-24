<?php
namespace src\CharacterCreation;

use src\Constant\Bootstrap;
use src\Constant\Constant;
use src\Constant\Field;
use src\Constant\Template;
use src\Entity\RpgFeat;
use src\Entity\RpgHerosFeat;
use src\Utils\Session;

class OriginFeatStep extends AbstractStep
{
    private const INITIATED_MAGIC_CLASSES = [3,4,7];
    private const SPECIAL_FEAT_ID = 5;

    public function validateAndSave(): void
    {
        if (!Session::isPostSubmitted()) {
            return; // Rien à valider
        }
        
        // On récupère et nettoie la valeur
        $firstFeatId = Session::fromPost('firstFeatId');
        $secondFeatId = Session::fromPost('secondFeatId', -1);
        $firstExtraFeatId = Session::fromPost('extraFirstFeatId', 0);
        $secondExtraFeatId = Session::fromPost('extraSecondFeatId', 0);

        $heroFeats = $this->deps['heroFeatRepo']->findBy([Field::HEROSID=>$this->hero->getField(Field::ID)]);
        foreach ($heroFeats as $heroFeat) {
            $this->deps['heroFeatRepo']->delete($heroFeat);
        }

        $heroFeat = new RpgHerosFeat([Field::HEROSID=>$this->hero->getField(Field::ID), Field::FEATID=>$firstFeatId, Field::EXTRA=>$firstExtraFeatId]);
        $this->deps['heroFeatRepo']->insert($heroFeat);
        if ($secondFeatId!=-1) {
            $heroFeat = new RpgHerosFeat([Field::HEROSID=>$this->hero->getField(Field::ID), Field::FEATID=>$secondFeatId, Field::EXTRA=>$secondExtraFeatId]);
            $this->deps['heroFeatRepo']->insert($heroFeat);
        }

        $this->hero->setField(Field::CREATESTEP, 'classe');
        $this->hero->setField(Field::LASTUPDATE, time());
        $this->deps['heroRepo']->update($this->hero);
    }

    public function renderStep(): array
    {
        $sidebar = (new SidebarRenderer($this->hero, $this->deps, $this->renderer, $this->stepMap))->render();
        $isHuman = $this->hero->getField(Field::SPECIESID)==7;

        // On a besoin de récupérer les feats d'origine associés au personnage s'il y en a
        $heroFeats = $this->deps['heroFeatRepo']->findBy([Field::HEROSID=>$this->hero->getField(Field::ID)]);
        $feats = iterator_to_array($heroFeats);
        $firstFeat = $feats[0] ?? null;
        $secondFeat = $feats[1] ?? null;
        $firstFeatId = $firstFeat?->getField(Field::FEATID) ?? -1;
        $firstExtraFeatId = $firstFeat?->getField(Field::EXTRA) ?? -1;
        $secondFeatId = $secondFeat?->getField(Field::FEATID) ?? -1;
        $secondExtraFeatId = $secondFeat?->getField(Field::EXTRA) ?? -1;

        // On récupère la liste des Dons d'origine pour les afficher.
        $feats = $this->deps['featRepo']->findBy([Field::FEATTYPEID=>1], [Field::NAME=>Constant::CST_ASC]);
        $primaryFeatHtml = '';
        $secondaryFeatHtml = '';
        foreach ($feats as $feat) {
            $primaryFeatHtml .= $feat->getController()->getRadioForm('firstFeatId', $firstFeatId == $feat->getField(Field::ID));
            if ($isHuman) {
                $secondaryFeatHtml .= $feat->getController()->getRadioForm('secondFeatId', $secondFeatId==$feat->getField(Field::ID));
            }
        }

        $classes = $this->deps['classRepo']->findAll([Field::NAME=>Constant::CST_ASC]);
        $secondaryExtraFeatHtml = '';
        $primaryExtraFeatHtml = '';
        foreach ($classes as $classe) {
            // Clerc, Druide et Magicien sont liés à "Initié à la magie"
            if (in_array($classe->getField(Field::ID), self::INITIATED_MAGIC_CLASSES)) {
                $primaryExtraFeatHtml .= $classe->getController()->getRadioForm('extraFirstFeatId', $firstExtraFeatId==$classe->getField(Field::ID));
                $secondaryExtraFeatHtml .= $classe->getController()->getRadioForm('extraSecondFeatId', $secondExtraFeatId==$classe->getField(Field::ID));
            }
        }

        return [
            'template'  => Template::CREATE_FEAT,
            'variables' => [
                'sidebar'           => $sidebar,
                'heroId'            => $this->hero->getField(Field::ID),
                'radioBtns'         => $primaryFeatHtml,
                'secondChoice'      => $isHuman ? '' : ' '.Bootstrap::CSS_DNONE,
                'radioBtns2nd'      => $secondaryFeatHtml,
                'showExtra1st'      => $firstFeatId==self::SPECIAL_FEAT_ID ? '' : ' '.Bootstrap::CSS_DNONE,
                'extraRadioBtns'    => $primaryExtraFeatHtml,
                'showExtra2nd'      => $isHuman && $secondFeatId==self::SPECIAL_FEAT_ID ? '' : ' '.Bootstrap::CSS_DNONE,
                'extraRadioBtns2nd' => $secondaryExtraFeatHtml,
                'description'       => $this->getDescription($firstFeat->getFeat()),
            ],
        ];
    }

    public static function getSidebarLabel(): string
    {
        return 'Don d\'origine';
    }

    public function getSidebarValue(): string
    {
        $heroFeats = $this->deps['heroFeatRepo']->findBy([Field::HEROSID => $this->hero->getField(Field::ID)]);
        $names = [];
        foreach ($heroFeats as $feat) {
            $names[] = $feat->getFullName();
        }
        return implode(', ', $names);
    }
    
    private function getDescription(?RpgFeat $feat): string
    {
        if ($feat===null) {
            $returned = "<strong>Caractéristiques</strong> : les 3 caractéristiques ajustées par l'origine.<br>";
            $returned .= "<strong>Don</strong> : le don d'origine associé.<br>";
            $returned .= "<strong>Compétences</strong> : le 2 compétences associées.<br>";
            $returned .= "<strong>Outils</strong> : l'outil associé.<br>";
            $returned .= "<strong>Equipement</strong> : la liste d'équipement standard disponible par l'origine<br>";

            return 'WIP';
        }
        return $feat->getController()->getDescription();
    }
}
