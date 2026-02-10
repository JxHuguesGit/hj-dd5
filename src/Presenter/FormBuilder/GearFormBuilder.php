<?php
namespace src\Presenter\FormBuilder;

use src\Constant\Bootstrap;
use src\Constant\Constant;
use src\Constant\Field;
use src\Constant\Language;
use src\Domain\Item as DomainItem;
use src\Utils\Form;
use src\Utils\UrlGenerator;

class GearFormBuilder extends AbstractFormBuilder implements FormBuilderInterface
{
    public function __construct(
        private string $type = Constant::EDIT,
    ) {}

    public function build(object $entity, array $params = []): Form
    {
        if (!$entity instanceof DomainItem) {
            throw new \InvalidArgumentException('Expected DomainItem');
        }

        $params[Constant::CST_TITLE] = 'Matériel : ' . $entity->name;
        $params[Constant::CST_TYPE] = $this->type;
        $params['cancelUrl'] = UrlGenerator::admin(Constant::ONG_COMPENDIUM, Constant::CST_GEAR);
        $params[Constant::CST_ACTION] = UrlGenerator::admin(Constant::ONG_COMPENDIUM, Constant::CST_GEAR, $entity->slug, $this->type);
        $form = $this->createForm($params);

        $mock = [
            ['value'=>'weapon', 'label'=>'Arme'],
            ['value'=>'armor',  'label'=>'Armure'],
            ['value'=>'ammo',   'label'=>'Munition'],
            ['value'=>'tool',   'label'=>'Outil'],
            ['value'=>'other',  'label'=>'Autre'],
        ];

        $form->addField(new NumberField(Field::ID, 'ID', $entity->id, true, ['outerDivClass'=>Bootstrap::CSS_COL_MD_3]))
            ->addField(new TextField(Field::NAME, 'Nom', $entity->name, $this->type==Constant::EDIT, ['outerDivClass'=>'col-md-5']))
            ->addField(new TextField(Field::SLUG, 'Slug', $entity->slug, true, ['outerDivClass'=>'col-md-4']))
            ->addField(new TextareaField(Field::DESCRIPTION, Language::LG_DESCRIPTION, $entity->description, false, ['outerDivClass'=>'col-md-12', 'style'=>'height: 200px']));
        if ($this->type==Constant::NEW) {
            $libelleType = (array_column($mock, 'label'))[array_search($entity->type, array_column($mock, 'value'))];
            $form->addField(new TextField(Field::TYPE, "Type d'objet", $libelleType, true, ['outerDivClass'=>'col-md-4']));
        } else {
            $form->addField(new SelectField(Field::TYPE, "Type d'objet", $entity->type, $mock, ['outerDivClass'=>'col-md-4']));
        }
        $form->addField(new NumberField(Field::GOLDPRICE, 'Prix (po)', $entity->goldPrice, false, ['outerDivClass'=>'col-md-4', 'step'=>'0.01']))
            ->addField(new NumberField(Field::WEIGHT, 'Poids (kg)', $entity->weight, false, ['outerDivClass'=>'col-md-4', 'step'=>'0.01']))
        ;

        return $form;
    }

}
