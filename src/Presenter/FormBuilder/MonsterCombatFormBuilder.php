<?php
namespace src\Presenter\FormBuilder;

use src\Constant\Bootstrap;
use src\Constant\Constant;
use src\Constant\Field;
use src\Constant\Language;
use src\Domain\Entity\SpeedType;
use src\Domain\Monster\Monster;
use src\Factory\ReaderFactory;

class MonsterCombatFormBuilder
{
    public function __construct(
        private ReaderFactory $readerFactory
    ) {}

    public function addFields(FieldsetField $fieldset, Monster $monster)
    {
        $fieldset
            ->addField(new ExtraNumberField(
                Field::SCORECA, Language::LG_CA, $monster->ca, false,
                ['extraValue' => $monster->getExtra(Field::SCORECA)]
            ))
            ->addField(new ExtraNumberField(
                Field::SCOREHP, Language::LG_PV, $monster->hp, false,
                ['extraValue' => $monster->getExtra(Field::SCOREHP)]
            ))
            ->addField(new NumberField(
                Field::SCORECR, Language::LG_FP, $monster->cr, false,
                [Constant::OUTERDIVCLASS => Bootstrap::CSS_COL_MD_2 . ' ' . Bootstrap::CSS_MB3]
            ))
            ->addField(new NumberField(
                Field::INITIATIVE, Language::LG_INITIATIVE, $monster->initiative, false,
                [Constant::OUTERDIVCLASS => Bootstrap::CSS_COL_MD_2 . ' ' . Bootstrap::CSS_MB3]
            ))
        ;
        $checkBoxAttributes = [Constant::OUTERDIVCLASS => Bootstrap::CSS_COL_MD_3 . ' ' . Bootstrap::CSS_MB3];
        if ($monster->legendary) {
            $checkBoxAttributes[Constant::CST_CHECKED] = Constant::CST_CHECKED;
        }
        $fieldset
            ->addField(new CheckboxField(Field::LEGENDARY, 'Légendaire', 1, false, $checkBoxAttributes))
            ->addField(new FillerField(
                '', '', '', '',
                [Constant::OUTERDIVCLASS => Bootstrap::CSS_COL_MD_5 . ' ' . Bootstrap::CSS_MB3]
            ))
        ;

        // Ici on devrait récupérer les types de vitesse
        // et boucler dessus pour passer à chaque fois un objet TypeSpeed
        $speedTypeReader = $this->readerFactory->speedType();
        $speedTypes      = $speedTypeReader->allSpeedTypes();
        foreach ($speedTypes as $speedType) {
            $this->addSpeedSection($fieldset, $monster, $speedType);
        }
    }

    private function addSpeedSection(FieldsetField $fieldset, Monster $monster, SpeedType $speedType)
    {
        // Ici, on devrait récupérer un objet TypeSpeed et utiliser slug et nom.
        // Où récupérer les données ?
        $monsterSpeed = $monster->speed($speedType->id);
        $frTag        = $speedType->frTag;

        $checkBoxAttributes = [Constant::OUTERDIVCLASS => Bootstrap::CSS_COL_MD_3 . ' ' . Bootstrap::CSS_MB3];
        if ($monsterSpeed->id) {
            $checkBoxAttributes[Constant::CST_CHECKED] = Constant::CST_CHECKED;
        }

        $fieldset
            ->addField(new CheckboxField(
                "speed_$frTag", ucfirst($frTag), $monsterSpeed->id, false, $checkBoxAttributes
            ))
            ->addField(new TextField(
                "value['$frTag']", 'Distance (m)', $monsterSpeed->value ?? '', false,
                [Constant::OUTERDIVCLASS => Bootstrap::CSS_COL_MD_2 . ' ' . Bootstrap::CSS_MB3]
            ))
            ->addField(new TextField(
                "extra['$frTag']", 'Complément', $monsterSpeed->extra ?? '', false,
                [Constant::OUTERDIVCLASS => Bootstrap::CSS_COL_MD_4 . ' ' . Bootstrap::CSS_MB3]
            ))
            ->addField(new FillerField(
                '', '', '', '',
                [Constant::OUTERDIVCLASS => Bootstrap::CSS_COL_MD_3 . ' ' . Bootstrap::CSS_MB3]
            ))
        ;
    }
}
