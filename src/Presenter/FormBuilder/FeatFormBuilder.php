<?php
namespace src\Presenter\FormBuilder;

use src\Domain\Feat as DomainFeat;
use src\Service\Domain\WpPostService;
use src\Utils\Form;

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

        $form = $this->createForm($params);

        $form->addField(new NumberField('id', 'id', 'ID', $entity->id, true))
            ->addField(new TextField('name', 'name', 'Nom', $entity->name, true))
            ->addField(new SelectField('featTypeId', 'featTypeId', 'Type de don', $entity->featTypeId, $mock))
            ->addField(new NumberField('postId', 'postId', 'Post ID', $entity->postId))
            ->addField(new TextField('slug', 'slug', 'Slug', $entity->slug, true))
            ->addField(new TextareaField('description', 'description', 'Description', $this->wpPostService->getPostContent(), true))
            ->addField(new TextField('prerequis', 'prerequis', 'Pré-requis', $this->wpPostService->getField('prerequis'), true))
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
