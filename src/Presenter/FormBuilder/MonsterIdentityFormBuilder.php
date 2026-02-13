<?php
namespace src\Presenter\FormBuilder;

use src\Constant\Bootstrap;
use src\Constant\Constant;
use src\Constant\Field;
use src\Domain\Monster\Monster;

class MonsterIdentityFormBuilder
{
    public function addFields(FieldsetField $fieldset, Monster $monster)
    {
        $options = [
            ['valeur'=>1, 'label'=>'Manuel des Monstres 2024'],
            ['valeur'=>2, 'label'=>'Manuel des Joueurs 2024'],
        ];
        $fieldset
            ->addField(new NumberField(
                Field::ID,
                'ID',
                $monster->id,
                true,
                [Constant::OUTERDIVCLASS => Bootstrap::CSS_COL_MD_2.' '.Bootstrap::CSS_MB3]
            ))
            ->addField(new TextField(
                Field::FRNAME,
                'Nom français',
                $monster->frName,
                false,
                [Constant::OUTERDIVCLASS=>Bootstrap::CSS_COL_MD_4]
            ))
            ->addField(new TextField(
                Field::NAME,
                'Nom anglais',
                $monster->name,
                true,
                [Constant::OUTERDIVCLASS=>Bootstrap::CSS_COL_MD_3]
            ))
            ->addField(new TextField(
                Field::UKTAG,
                'Slug',
                $monster->ukTag,
                true,
                [Constant::OUTERDIVCLASS=>Bootstrap::CSS_COL_MD_3]
            ))
            ->addField(new SelectField(
                Field::REFID,
                'Référence',
                $monster->ukTag,
                $options,
                [Constant::OUTERDIVCLASS=>Bootstrap::CSS_COL_MD_4.' '.Bootstrap::CSS_MB3]
            ))
        ;
    }
}
