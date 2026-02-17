<?php
namespace src\Presenter\FormBuilder;

use src\Constant\{Bootstrap, Constant, Field, Language};
use src\Domain\Entity\SpeedType;
use src\Domain\Monster\Monster;
use src\Domain\Monster\MonsterSpeedType;
use src\Factory\ReaderFactory;

class MonsterClassificationFormBuilder
{
    public function __construct(
        private ReaderFactory $readerFactory
    ) {}

    public function addFields(FieldsetField $fieldset, Monster $monster)
    {
        $optionTypes = [];
        $optionSubTypes = [];
        $optionAlignements = [];
        $optionSizes = [];

        $fieldset
            ->addField(new SelectField(
                Field::MSTTYPEID,
                'Type',
                $monster->monstreTypeId,
                $optionTypes,
                [Constant::OUTERDIVCLASS=>Bootstrap::CSS_COL_MD_4.' '.Bootstrap::CSS_MB3]
            ))
            ->addField(new SelectField(
                Field::MSTSSTYPID,
                'Sous Type',
                $monster->monsterSubTypeId,
                $optionSubTypes,
                [Constant::OUTERDIVCLASS=>Bootstrap::CSS_COL_MD_4.' '.Bootstrap::CSS_MB3]
            ))
            ->addField(new SelectField(
                Field::ALGNID,
                'Alignement',
                $monster->alignmentId,
                $optionAlignements,
                [Constant::OUTERDIVCLASS=>Bootstrap::CSS_COL_MD_4.' '.Bootstrap::CSS_MB3]
            ))
            ->addField(new SelectField(
                Field::MSTSIZE,
                'Taille',
                $monster->monsterSize,
                $optionSizes,
                [Constant::OUTERDIVCLASS=>Bootstrap::CSS_COL_MD_4.' '.Bootstrap::CSS_MB3]
            ))
/*
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
*/
        ;
    }

}
