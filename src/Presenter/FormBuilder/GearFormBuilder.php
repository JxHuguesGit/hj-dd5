<?php
namespace src\Presenter\FormBuilder;

use src\Constant\Bootstrap as B;
use src\Constant\Constant as C;
use src\Constant\Field as F;
use src\Constant\Language as L;
use src\Domain\Entity\Item;
use src\Utils\Form;
use src\Utils\UrlGenerator;

class GearFormBuilder extends AbstractFormBuilder implements FormBuilderInterface
{
    public function __construct(
        private string $type = C::EDIT,
    ) {}

    public function build(object $entity, array $params = []): Form
    {
        if (! $entity instanceof Item) {
            throw new \InvalidArgumentException('Expected DomainItem');
        }

        $params[C::TITLE]  = 'Matériel : ' . $entity->name;
        $params[C::TYPE]   = $this->type;
        $params['cancelUrl']   = UrlGenerator::admin(C::ONG_COMPENDIUM, C::GEAR);
        $params[C::ACTION] = UrlGenerator::admin(C::ONG_COMPENDIUM, C::GEAR, $entity->slug, $this->type);
        $form                  = $this->createForm($params);

        $mock = [
            [C::VALUE => C::WEAPON, C::LABEL => 'Arme'],
            [C::VALUE => C::ARMOR, C::LABEL => 'Armure'],
            [C::VALUE => 'ammo', C::LABEL => 'Munition'],
            [C::VALUE => C::TOOL, C::LABEL => L::TOOL],
            [C::VALUE => 'other', C::LABEL => 'Autre'],
        ];

        $fieldset = new FieldsetField('');

        $fieldset
            ->addField(new NumberField(
                F::ID, 'ID', $entity->id, true,
                [C::OUTERDIVCLASS => B::COL_MD_3 . ' ' . B::MB3]
            ))
            ->addField(new TextField(
                F::NAME, 'Nom', $entity->name, $this->type == C::EDIT,
                [C::OUTERDIVCLASS => B::COL_MD_5]
            ))
            ->addField(new TextField(
                F::SLUG, 'Slug', $entity->slug, true,
                [C::OUTERDIVCLASS => B::COL_MD_4]
            ))
            ->addField(new TextareaField(
                F::DESCRIPTION, L::DESCRIPTION, $entity->description, false,
                [C::OUTERDIVCLASS => B::COL_MD_12 . ' ' . B::MB3, 'style' => 'height: 200px']
            ))
        ;

        if ($this->type == C::NEW ) {
            $libelleType = (array_column($mock, C::LABEL))[array_search($entity->type, array_column($mock, C::VALUE))];
            $fieldset->addField(new TextField(
                F::TYPE, "Type d'objet", $libelleType, true,
                [C::OUTERDIVCLASS => B::COL_MD_4 . ' ' . B::MB3]
            ));
        } else {
            $fieldset->addField(new SelectField(
                F::TYPE, "Type d'objet", $entity->type, $mock,
                [C::OUTERDIVCLASS => B::COL_MD_4 . ' ' . B::MB3]
            ));
        }

        $fieldset
            ->addField(new NumberField(
                F::GOLDPRICE, 'Prix (po)', $entity->goldPrice, false,
                [C::OUTERDIVCLASS => B::COL_MD_4, 'step' => '0.01']
            ))
            ->addField(new NumberField(
                F::WEIGHT, 'Poids (kg)', $entity->weight, false,
                [C::OUTERDIVCLASS => B::COL_MD_4, 'step' => '0.01']
            ))
        ;

        $form->addField($fieldset);
        return $form;
    }

}
