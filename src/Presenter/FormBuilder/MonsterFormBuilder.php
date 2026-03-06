<?php
namespace src\Presenter\FormBuilder;

use src\Constant\Constant as C;
use src\Domain\Monster\Monster;
use src\Factory\ReaderFactory;
use src\Factory\RepositoryFactory;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Utils\Form;
use src\Utils\UrlGenerator;

class MonsterFormBuilder extends AbstractFormBuilder implements FormBuilderInterface
{
    private array $sections = [
        MonsterIdentityFormBuilder::class => 'Identité',
        MonsterCombatFormBuilder::class => 'Combat',
        MonsterClassificationFormBuilder::class => 'Classification',
    ];

    public function build(object $entity, array $params = []): Form
    {
        if (!$entity instanceof Monster) {
            throw new \InvalidArgumentException('Expected \Domain\Monster\Monster');
        }

        $params[C::TITLE] = 'Monstre : ' . $entity->name;
        $params[C::TYPE] = C::EDIT;
        $params[C::CSSCLASS] = 'pt-3';
        $params['cancelUrl'] = UrlGenerator::admin(C::ONG_COMPENDIUM, C::MONSTERS);
        $form = $this->createForm($params);

        foreach ($this->sections as $sectionClass => $title) {
            $fieldset = new FieldsetField($title, true);
            $section = new $sectionClass(
                new ReaderFactory(
                    new RepositoryFactory(
                        new QueryBuilder(),
                        new QueryExecutor()
                    )
                ),
            );
            $section->addFields($fieldset, $entity);
            $form->addField($fieldset);
        }

        return $form;
    }

}
