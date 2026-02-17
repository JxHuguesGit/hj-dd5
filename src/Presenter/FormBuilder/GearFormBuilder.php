<?php
namespace src\Presenter\FormBuilder;

use src\Constant\{Bootstrap, Constant, Field, Language};
use src\Domain\Entity\Item;
use src\Utils\Form;
use src\Utils\UrlGenerator;

class GearFormBuilder extends AbstractFormBuilder implements FormBuilderInterface
{
    public function __construct(
        private string $type = Constant::EDIT,
    ) {}

    public function build(object $entity, array $params = []): Form
    {
        if (!$entity instanceof Item) {
            throw new \InvalidArgumentException('Expected DomainItem');
        }

        $params[Constant::CST_TITLE] = 'Matériel : ' . $entity->name;
        $params[Constant::CST_TYPE] = $this->type;
        $params['cancelUrl'] = UrlGenerator::admin(Constant::ONG_COMPENDIUM, Constant::CST_GEAR);
        $params[Constant::CST_ACTION] = UrlGenerator::admin(Constant::ONG_COMPENDIUM, Constant::CST_GEAR, $entity->slug, $this->type);
        $form = $this->createForm($params);

        $mock = [
            [Constant::CST_VALUE=>Constant::CST_WEAPON, Constant::CST_LABEL=>'Arme'],
            [Constant::CST_VALUE=>Constant::CST_ARMOR,  Constant::CST_LABEL=>'Armure'],
            [Constant::CST_VALUE=>'ammo',   Constant::CST_LABEL=>'Munition'],
            [Constant::CST_VALUE=>Constant::CST_TOOL,   Constant::CST_LABEL=>'Outil'],
            [Constant::CST_VALUE=>'other',  Constant::CST_LABEL=>'Autre'],
        ];

        $fieldset = new FieldsetField('');

        $fieldset
            ->addField(new NumberField(
                Field::ID, 'ID', $entity->id, true,
                [Constant::OUTERDIVCLASS=>Bootstrap::CSS_COL_MD_3.' '.Bootstrap::CSS_MB3]
            ))
            ->addField(new TextField(
                Field::NAME, 'Nom', $entity->name, $this->type==Constant::EDIT,
                [Constant::OUTERDIVCLASS => Bootstrap::CSS_COL_MD_5]
            ))
            ->addField(new TextField(
                Field::SLUG, 'Slug', $entity->slug, true,
                [Constant::OUTERDIVCLASS => Bootstrap::CSS_COL_MD_4]
            ))
            ->addField(new TextareaField(
                Field::DESCRIPTION, Language::LG_DESCRIPTION, $entity->description, false,
                [Constant::OUTERDIVCLASS=>'col-md-12'.' '.Bootstrap::CSS_MB3, 'style'=>'height: 200px']
            ));

        if ($this->type==Constant::NEW) {
            $libelleType = (array_column($mock, Constant::CST_LABEL))[array_search($entity->type, array_column($mock, Constant::CST_VALUE))];
            $fieldset->addField(new TextField(
                Field::TYPE, "Type d'objet", $libelleType, true,
                [Constant::OUTERDIVCLASS => Bootstrap::CSS_COL_MD_4.' '.Bootstrap::CSS_MB3]
            ));
        } else {
            $fieldset->addField(new SelectField(
                Field::TYPE, "Type d'objet", $entity->type, $mock,
                [Constant::OUTERDIVCLASS => Bootstrap::CSS_COL_MD_4.' '.Bootstrap::CSS_MB3]
            ));
        }
        $fieldset
            ->addField(new NumberField(
                Field::GOLDPRICE, 'Prix (po)', $entity->goldPrice, false,
                [Constant::OUTERDIVCLASS => Bootstrap::CSS_COL_MD_4, 'step'=>'0.01']
            ))
            ->addField(new NumberField(
                Field::WEIGHT, 'Poids (kg)', $entity->weight, false,
                [Constant::OUTERDIVCLASS => Bootstrap::CSS_COL_MD_4, 'step'=>'0.01']
            ))
        ;

        $form->addField($fieldset);
        return $form;
    }

}
