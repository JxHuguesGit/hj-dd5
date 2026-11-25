<?php

namespace src\Presenter\FormBuilder;

use src\Constant\Bootstrap as B;
use src\Constant\Constant as C;
use src\Constant\Field as F;
use src\Domain\Entity\InitiativeTracker;
use src\Utils\Form;
use src\Utils\Session;
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

        $users = Session::isAdmin()
            ? get_users([
                'orderby' => 'display_name',
                'order'   => 'ASC',
            ])
            : [wp_get_current_user()];

        $selectElements = array_map(
            fn(\WP_User $u) => [
                C::VALUE => $u->ID,
                C::LABEL => $u->first_name . ' ' . $u->last_name,
            ],
            $users
        );

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
            ->addField(new SelectField(
                F::WPUSERID,
                'Admin',
                $entity->wpUserId,
                $selectElements,
                [C::OUTERDIVCLASS => B::COL_MD_4 . ' ' . B::MB3 . ' ' . B::MT5]
            ))
            ->addField(new TextField(
                F::NAME,
                'Nom du combat',
                $entityName,
                false,
                [C::OUTERDIVCLASS => B::COL_MD_4 . ' ' . B::MB3 . ' ' . B::MT5]
            ))
        ;
        $form->addField($fieldset);
        return $form;
    }
}
