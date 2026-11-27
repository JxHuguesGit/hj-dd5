<?php

namespace src\Presenter\FormBuilder;

use src\Constant\Bootstrap as B;
use src\Constant\Constant as C;
use src\Constant\Field as F;
use src\Domain\Criteria\MonsterSubTypeCriteria;
use src\Domain\Criteria\MonsterTypeCriteria;
use src\Domain\Monster\Monster;
use src\Enum\AlignmentEnum;
use src\Enum\SizeEnum;
use src\Factory\ReaderFactory;

class MonsterClassificationFormBuilder
{
    public function __construct(
        private ReaderFactory $readerFactory
    ) {}

    public function addFields(FieldsetField $fieldset, Monster $monster)
    {
        ////////////////////////////////////////////////////////////////////////
        // Construction de la liste des Types (SousTypes)
        $criteria = new MonsterTypeCriteria();
        $criteria->abbr = '';
        $monsterTypes = $this->readerFactory->monsterType()->allMonsterTypes($criteria);
        $optionTypes = [];
        $criteria = new MonsterSubTypeCriteria();
        foreach ($monsterTypes as $type) {
            $optionTypes[] = [
                C::VALUE => $type->id . '|0',
                C::LABEL => ($type->getNameAndGender())[C::LABEL],
            ];

            $criteria->monstreTypeId = $type->id;
            $subTypes = $this->readerFactory
                ->monsterSubType()
                ->allMonsterSubTypes($criteria);
            if ($subTypes->isEmpty()) {
                continue;
            }

            foreach ($subTypes as $subType) {
                $optionTypes[] = [
                    C::VALUE => $type->id . '|' . $subType->id,
                    C::LABEL => sprintf(
                        '%s (%s)',
                        ($type->getNameAndGender())[C::LABEL],
                        $subType->getStrName()
                    ),
                ];
            }
        }
        ////////////////////////////////////////////////////////////////////////

        ////////////////////////////////////////////////////////////////////////
        // Construction de la liste des Tailles
        $optionSizes = SizeEnum::options();
        array_unshift($optionSizes, [C::VALUE => 0, C::LABEL => '']);
        ////////////////////////////////////////////////////////////////////////

        ////////////////////////////////////////////////////////////////////////
        // Construction de la liste des Alignements
        $optionAlignements = AlignmentEnum::options(true);
        ////////////////////////////////////////////////////////////////////////

        $fieldset
            ->addField(new SelectField(
                F::SWARMSIZE,
                'Taille de la nuée',
                $monster->swarmSize,
                $optionSizes,
                [C::OUTERDIVCLASS => B::COL_MD_3 . ' ' . B::MB3]
            ))
            ->addField(new SelectField(
                F::MSTTYPEID,
                'Type',
                $monster->monstreTypeId . '|' . ($monster->monsterSubTypeId ?? 0),
                $optionTypes,
                [C::OUTERDIVCLASS => B::COL_MD_6 . ' ' . B::MB3]
            ))
            ->addField(new SelectField(
                F::MSTSIZE,
                'Taille',
                $monster->monsterSize,
                $optionSizes,
                [C::OUTERDIVCLASS => B::COL_MD_3 . ' ' . B::MB3]
            ))
            ->addField(new SelectField(
                F::ALGNID,
                'Alignement',
                $monster->alignmentId,
                $optionAlignements,
                [C::OUTERDIVCLASS => B::COL_MD_3 . ' ' . B::MB3]
            ))
        ;
    }
}
