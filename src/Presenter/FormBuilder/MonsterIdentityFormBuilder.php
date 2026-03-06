<?php
namespace src\Presenter\FormBuilder;

use src\Constant\Bootstrap as B;
use src\Constant\Constant as C;
use src\Constant\Field as F;
use src\Constant\Language as L;
use src\Domain\Monster\Monster;
use src\Factory\ReaderFactory;

class MonsterIdentityFormBuilder
{
    public function __construct(
        private ReaderFactory $readerFactory
    ) {}

    public function addFields(FieldsetField $fieldset, Monster $monster)
    {
        $reader     = $this->readerFactory->reference();
        $references = $reader->allReferences();
        $options    = [];
        foreach ($references as $reference) {
            $options[] = ['valeur' => $reference->id, C::LABEL => $reference->name];
        }
        $fieldset
            ->addField(new NumberField(
                F::ID,
                'ID',
                $monster->id,
                true,
                [C::OUTERDIVCLASS => B::COL_MD_2 . ' ' . B::MB3]
            ))
            ->addField(new TextField(
                F::FRNAME,
                'Nom français',
                $monster->frName,
                false,
                [C::OUTERDIVCLASS => B::COL_MD_4]
            ))
            ->addField(new TextField(
                F::NAME,
                'Nom anglais',
                $monster->name,
                true,
                [C::OUTERDIVCLASS => B::COL_MD_3]
            ))
            ->addField(new TextField(
                F::UKTAG,
                'Slug',
                $monster->ukTag,
                true,
                [C::OUTERDIVCLASS => B::COL_MD_3]
            ))
            ->addField(new SelectField(
                F::REFID,
                L::REFERENCE,
                $monster->ukTag,
                $options,
                [C::OUTERDIVCLASS => B::COL_MD_4 . ' ' . B::MB3]
            ))
        ;
    }
}
