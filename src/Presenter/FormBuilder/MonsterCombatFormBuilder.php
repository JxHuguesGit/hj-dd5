<?php
namespace src\Presenter\FormBuilder;

use src\Constant\{Bootstrap, Constant, Field, Language};
use src\Domain\Entity\SpeedType;
use src\Domain\Monster\Monster;
use src\Domain\Monster\MonsterSpeedType;
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
                [Constant::OUTERDIVCLASS=>Bootstrap::CSS_COL_MD_2.' '.Bootstrap::CSS_MB3]
            ))
            ->addField(new NumberField(
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
        $speedTypeReader = $this->readerFactory->speedType();
        $speedTypes = $speedTypeReader->allSpeedTypes([Field::ID=>Constant::CST_ASC]);
        foreach ($speedTypes as $speedType) {
            $this->addSpeedSection($fieldset, $monster, $speedType);
        }
    }

    private function addSpeedSection(FieldsetField $fieldset, Monster $monster, SpeedType $speedType)
    {
        // Ici, on devrait récupérer un objet TypeSpeed et utiliser slug et nom.
        // Où récupérer les données ?
        $monsterSpeed = $monster->speed($speedType->id);
        $frTag = $speedType->frTag;

        $fieldset
            ->addField(new CheckboxField(
                "speed_$frTag", ucfirst($frTag), $monsterSpeed->id ? 1 : 0, false,
                [
                    Constant::OUTERDIVCLASS=>Bootstrap::CSS_COL_MD_3.' '.Bootstrap::CSS_MB3
                ]
            ))
            ->addField(new TextField(
                "value['$frTag']", 'Distance (m)', $monsterSpeed->value ?? '', false,
                [Constant::OUTERDIVCLASS=>Bootstrap::CSS_COL_MD_2.' '.Bootstrap::CSS_MB3]
            ))
            ->addField(new TextField(
                "extra['$frTag']", 'Complément', $monsterSpeed->extra ?? '', false,
                [Constant::OUTERDIVCLASS=>Bootstrap::CSS_COL_MD_4.' '.Bootstrap::CSS_MB3]
            ))
            ->addField(new FillerField(
                '', '', '', '',
                [Constant::OUTERDIVCLASS=>Bootstrap::CSS_COL_MD_3.' '.Bootstrap::CSS_MB3]
            ))
        ;
    }
}
