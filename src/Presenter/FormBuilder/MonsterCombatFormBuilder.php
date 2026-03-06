<?php
namespace src\Presenter\FormBuilder;

use src\Constant\Bootstrap as B;
use src\Constant\Constant as C;
use src\Constant\Field as F;
use src\Constant\Language as L;
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
                F::SCORECA, L::CA, $monster->ca, false,
                ['extraValue' => $monster->getExtra(F::SCORECA)]
            ))
            ->addField(new ExtraNumberField(
                F::SCOREHP, L::PV, $monster->hp, false,
                ['extraValue' => $monster->getExtra(F::SCOREHP)]
            ))
            ->addField(new NumberField(
                F::SCORECR, L::FP, $monster->cr, false,
                [C::OUTERDIVCLASS => B::COL_MD_2 . ' ' . B::MB3]
            ))
            ->addField(new NumberField(
                F::INITIATIVE, L::INITIATIVE, $monster->initiative, false,
                [C::OUTERDIVCLASS => B::COL_MD_2 . ' ' . B::MB3]
            ))
        ;
        $checkBoxAttributes = [C::OUTERDIVCLASS => B::COL_MD_3 . ' ' . B::MB3];
        if ($monster->legendary) {
            $checkBoxAttributes[C::CHECKED] = C::CHECKED;
        }
        $fieldset
            ->addField(new CheckboxField(F::LEGENDARY, 'Légendaire', 1, false, $checkBoxAttributes))
            ->addField(new FillerField(
                '', '', '', '',
                [C::OUTERDIVCLASS => B::COL_MD_5 . ' ' . B::MB3]
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

        $checkBoxAttributes = [C::OUTERDIVCLASS => B::COL_MD_3 . ' ' . B::MB3];
        if ($monsterSpeed->id) {
            $checkBoxAttributes[C::CHECKED] = C::CHECKED;
        }

        $fieldset
            ->addField(new CheckboxField(
                "speed_$frTag", ucfirst($frTag), $monsterSpeed->id, false, $checkBoxAttributes
            ))
            ->addField(new TextField(
                "value['$frTag']", 'Distance (m)', $monsterSpeed->value ?? '', false,
                [C::OUTERDIVCLASS => B::COL_MD_2 . ' ' . B::MB3]
            ))
            ->addField(new TextField(
                "extra['$frTag']", 'Complément', $monsterSpeed->extra ?? '', false,
                [C::OUTERDIVCLASS => B::COL_MD_4 . ' ' . B::MB3]
            ))
            ->addField(new FillerField(
                '', '', '', '',
                [C::OUTERDIVCLASS => B::COL_MD_3 . ' ' . B::MB3]
            ))
        ;
    }
}
