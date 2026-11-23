<?php

namespace src\Presenter\FormBuilder;

use src\Constant\Bootstrap as B;
use src\Constant\Constant as C;
use src\Constant\Field as F;
use src\Domain\Entity\InitiativeTracker;
use src\Utils\Form;
use src\Utils\UrlGenerator;

class InitiativeTrackerFormBuilder extends AbstractFormBuilder implements FormBuilderInterface
{
    public function build(object $entity, array $params = []): Form
    {
        if (! $entity instanceof InitiativeTracker) {
            throw new \InvalidArgumentException('Expected InitiativeTracker');
        }

        $entityId      = $entity->id ?? -1;
        $newEntity = ($entityId == -1 || $entityId == 0);
        $params[C::TITLE]    = $newEntity ? 'Nouveau Combat' : 'Combat : ' . $entity->name;
        $params[C::TYPE]     = $newEntity ? C::NEW : C::EDIT;
        $params['cancelUrl'] = UrlGenerator::admin(C::ONG_TIMELINE, '');
        $form                = $this->createForm($params);
        $entityName          = $newEntity ? '' : $entity->name;

        //////////////////////////
        // Fieldset principal
        $fieldset = new FieldsetField('');
        $fieldset
            ->addField(new NumberField(
                F::ID,
                'ID',
                $entity->id,
                true,
                [C::OUTERDIVCLASS => B::COL_MD_2 . ' ' . B::MB3 . ' ' . B::MT5]
            ))
            ->addField(new TextField(
                F::ITCODE,
                'IT Code',
                $entity->iTCode,
                false,
                [C::OUTERDIVCLASS => B::COL_MD_2 . ' ' . B::MB3 . ' ' . B::MT5]
            ))
            ->addField(new TextField(
                F::NAME,
                'Nom du combat',
                $entityName,
                false,
                [C::OUTERDIVCLASS => B::COL_MD_4 . ' ' . B::MB3 . ' ' . B::MT5]
            ))
            ->addField(new EmptyField([C::CSSCLASS => B::COL_MD_4]))
        ;
        $form->addField($fieldset);
        return $form;
    }
}
