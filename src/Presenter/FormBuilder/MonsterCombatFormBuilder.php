<?php
namespace src\Presenter\FormBuilder;

use src\Constant\Bootstrap;
use src\Constant\Constant;
use src\Constant\Field;
use src\Constant\Language;
use src\Domain\Monster\Monster;

class MonsterCombatFormBuilder
{
    public function addFields(FieldsetField $fieldset, Monster $monster)
    {
        $fieldset
            ->addField(new ExtraTextField(
                Field::SCORECA, Language::LG_CA, $monster->ca, false,
                ['extraValue' => $monster->getExtra(Field::SCORECA)]
            ))
            ->addField(new ExtraTextField(
                Field::SCOREHP, Language::LG_PV, $monster->hp, false,
                ['extraValue' => $monster->getExtra(Field::SCOREHP)]
            ))
            ->addField(new TextField(
                Field::SCORECR, Language::LG_FP, $monster->cr, false,
                [Constant::OUTERDIVCLASS=>Bootstrap::CSS_COL_MD_2.' '.Bootstrap::CSS_MB3]
            ))
            ->addField(new TextField(
                Field::INITIATIVE, 'Initiative', $monster->initiative, false,
                [Constant::OUTERDIVCLASS=>Bootstrap::CSS_COL_MD_2.' '.Bootstrap::CSS_MB3]
            ))
            ->addField(new CheckboxField(
                Field::LEGENDARY, 'Légendaire', $monster->legendary, false,
                [Constant::OUTERDIVCLASS=>Bootstrap::CSS_COL_MD_3.' '.Bootstrap::CSS_MB3]
            ))
            ->addField(new FillerField(
                '', '', '', '',
                [Constant::OUTERDIVCLASS=>Bootstrap::CSS_COL_MD_5.' '.Bootstrap::CSS_MB3]
            ))
        ;

        // Ici on devrait récupérer les types de vitesse
        // et boucler dessus pour passer à chaque fois un objet TypeSpeed
        $this->addSpeedSection($fieldset, $monster, 'marche');
        $this->addSpeedSection($fieldset, $monster, 'vol');
        $this->addSpeedSection($fieldset, $monster, 'nage');
        $this->addSpeedSection($fieldset, $monster, 'escalade');
        $this->addSpeedSection($fieldset, $monster, 'fouissement');

    }

    private function addSpeedSection(FieldsetField $fieldset, Monster $monster, string $slugSpeed)
    {
        // Ici, on devrait récupérer un objet TypeSpeed et utiliser slug et nom.
        // Où récupérer les données ?
        $fieldset
            ->addField(new CheckboxField(
                "speed_$slugSpeed", ucfirst($slugSpeed), '', false,
                [Constant::OUTERDIVCLASS=>Bootstrap::CSS_COL_MD_3.' '.Bootstrap::CSS_MB3]
            ))
            ->addField(new TextField(
                "value['$slugSpeed']", 'Distance (m)', '', false,
                [Constant::OUTERDIVCLASS=>Bootstrap::CSS_COL_MD_2.' '.Bootstrap::CSS_MB3]
            ))
            ->addField(new TextField(
                "extra['$slugSpeed']", 'Complément', '', false,
                [Constant::OUTERDIVCLASS=>Bootstrap::CSS_COL_MD_4.' '.Bootstrap::CSS_MB3]
            ))
            ->addField(new FillerField(
                '', '', '', '',
                [Constant::OUTERDIVCLASS=>Bootstrap::CSS_COL_MD_3.' '.Bootstrap::CSS_MB3]
            ))
        ;
    }
}