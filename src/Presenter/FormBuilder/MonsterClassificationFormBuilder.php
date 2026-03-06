<?php
namespace src\Presenter\FormBuilder;

use src\Constant\Bootstrap as B;
use src\Constant\Constant as C;
use src\Constant\Field as F;
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
                F::MSTTYPEID,
                'Type',
                $monster->monstreTypeId,
                $optionTypes,
                [C::OUTERDIVCLASS => B::COL_MD_4 . ' ' . B::MB3]
            ))
            ->addField(new SelectField(
                F::MSTSSTYPID,
                'Sous Type',
                $monster->monsterSubTypeId,
                $optionSubTypes,
                [C::OUTERDIVCLASS => B::COL_MD_4 . ' ' . B::MB3]
            ))
            ->addField(new SelectField(
                F::ALGNID,
                'Alignement',
                $monster->alignmentId,
                $optionAlignements,
                [C::OUTERDIVCLASS => B::COL_MD_4 . ' ' . B::MB3]
            ))
            ->addField(new SelectField(
                F::MSTSIZE,
                'Taille',
                $monster->monsterSize,
                $optionSizes,
                [C::OUTERDIVCLASS => B::COL_MD_4 . ' ' . B::MB3]
            ))
        ;
    }

}
