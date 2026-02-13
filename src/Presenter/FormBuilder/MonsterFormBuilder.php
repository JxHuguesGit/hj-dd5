<?php
namespace src\Presenter\FormBuilder;

use src\Constant\Constant;
use src\Domain\Monster\Monster;
use src\Utils\Form;
use src\Utils\UrlGenerator;

class MonsterFormBuilder extends AbstractFormBuilder implements FormBuilderInterface
{
    private array $sections = [
        MonsterIdentityFormBuilder::class => 'Identité',
        MonsterCombatFormBuilder::class => 'Combat',
    ];

    public function build(object $entity, array $params = []): Form
    {
        if (!$entity instanceof Monster) {
            throw new \InvalidArgumentException('Expected \Domain\Monster\Monster');
        }

        $params[Constant::CST_TITLE] = 'Monstre : ' . $entity->name;
        $params[Constant::CST_TYPE] = Constant::EDIT;
        $params[Constant::CST_CLASS] = 'pt-5';
        $params['cancelUrl'] = UrlGenerator::admin(Constant::ONG_COMPENDIUM, Constant::MONSTERS);
        $form = $this->createForm($params);

        foreach ($this->sections as $sectionClass => $title) {
            $fieldset = new FieldsetField($title, true);
            $section = new $sectionClass();
            $section->addFields($fieldset, $entity);
            $form->addField($fieldset);
        }

        return $form;
    }

}
