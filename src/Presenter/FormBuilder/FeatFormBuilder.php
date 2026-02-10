<?php
namespace src\Presenter\FormBuilder;

use src\Constant\Bootstrap;
use src\Constant\Constant;
use src\Constant\Field;
use src\Constant\Language;
use src\Domain\Feat as DomainFeat;
use src\Service\Domain\WpPostService;
use src\Utils\Form;
use src\Utils\UrlGenerator;

class FeatFormBuilder extends AbstractFormBuilder implements FormBuilderInterface
{
    public function __construct(
        private WpPostService $wpPostService,
    ) {}

    public function build(object $entity, array $params = []): Form
    {
        if (!$entity instanceof DomainFeat) {
            throw new \InvalidArgumentException('Expected DomainFeat');
        }

/*
        $typeFeats = $this->typeFeatRepo->findAll();
*/
        $mock = [
            ['value'=>1, 'label'=>'Origine'],
            ['value'=>2, 'label'=>'Général'],
            ['value'=>3, 'label'=>'Style de combat'],
            ['value'=>4, 'label'=>'Faveur épique'],
        ];
        $this->wpPostService->getById($entity->postId);

        $params[Constant::CST_TITLE] = 'Don : ' . $entity->name;
        $params[Constant::CST_TYPE] = Constant::EDIT;
        $params['cancelUrl'] = UrlGenerator::admin(Constant::ONG_COMPENDIUM, Constant::FEATS);
        $form = $this->createForm($params);

        $form->addField(new NumberField(Field::ID, 'ID', $entity->id, true, ['outerDivClass'=>Bootstrap::CSS_COL_MD_3]))
            ->addField(new TextField(Field::NAME, Constant::CST_NAME, $entity->name, true, ['outerDivClass'=>'col-md-5']))
            ->addField(new SelectField(Field::FEATTYPEID, 'Type de don', $entity->featTypeId, $mock, ['outerDivClass'=>'col-md-4']))
            ->addField(new NumberField(Field::POSTID, 'Post ID', $entity->postId, false, ['outerDivClass'=>'col-md-4']))
            ->addField(new TextField(Field::SLUG, Constant::CST_SLUG, $entity->slug, true, ['outerDivClass'=>'col-md-8']))
            ->addField(new TextareaField(Field::DESCRIPTION, Language::LG_DESCRIPTION, $this->wpPostService->getPostContent(), true, ['outerDivClass'=>'col-md-12', 'style'=>'height: 200px']))
            ->addField(new TextField('prerequis', Language::LG_PREQUISITE, $this->wpPostService->getField('prerequis'), true, ['outerDivClass'=>'col-md-12']))
        ;

        return $form;
        /*
            new SelectField(
                'featTypeId',
                'Type de don',
                $entity->getFeatTypeId(),
                array_map(fn($t) => ['value' => $t->getId(), 'label' => $t->getName()], $typeFeats->toArray())
            ),
        */
    }

}
