<?php
namespace src\Presenter\FormBuilder;

use src\Constant\Bootstrap as B;
use src\Constant\Constant;
use src\Constant\Field;
use src\Domain\Monster\Monster;
use src\Factory\ReaderFactory;

class MonsterClassificationFormBuilder
{
    public function __construct(
        private ReaderFactory $readerFactory
    ) {
        // Supprimer une alerte Sonar
        unset($this->readerFactory);
    }

    public function addFields(FieldsetField $fieldset, Monster $monster)
    {
        $optionTypes       = [];
        $optionSubTypes    = [];
        $optionAlignements = [];
        $optionSizes       = [];

        $fieldset
            ->addField(new SelectField(
                Field::MSTTYPEID,
                'Type',
                $monster->monstreTypeId,
                $optionTypes,
                [Constant::OUTERDIVCLASS => B::COL_MD_4 . ' ' . B::MB3]
            ))
            ->addField(new SelectField(
                Field::MSTSSTYPID,
                'Sous Type',
                $monster->monsterSubTypeId,
                $optionSubTypes,
                [Constant::OUTERDIVCLASS => B::COL_MD_4 . ' ' . B::MB3]
            ))
            ->addField(new SelectField(
                Field::ALGNID,
                'Alignement',
                $monster->alignmentId,
                $optionAlignements,
                [Constant::OUTERDIVCLASS => B::COL_MD_4 . ' ' . B::MB3]
            ))
            ->addField(new SelectField(
                Field::MSTSIZE,
                'Taille',
                $monster->monsterSize,
                $optionSizes,
                [Constant::OUTERDIVCLASS => B::COL_MD_4 . ' ' . B::MB3]
            ))
        ;
    }

}
