<?php

namespace src\Presenter\FormBuilder;

use src\Constant\Bootstrap as B;
use src\Constant\Constant as C;
use src\Domain\Monster\Monster;
use src\Factory\ReaderFactory;
use src\Renderer\TemplateRenderer;
use src\Utils\Form;
use src\Utils\UrlGenerator;

class MonsterFormBuilder extends AbstractFormBuilder implements FormBuilderInterface
{
    private array $sections = [
        MonsterIdentityFormBuilder::class => 'Identité',
        MonsterCombatFormBuilder::class => 'Combat',
        MonsterClassificationFormBuilder::class => 'Classification',
    ];

    public function __construct(
        private ReaderFactory $readerFactory
    ) {}

    public function build(object $entity, array $params = []): Form
    {
        if (!$entity instanceof Monster) {
            throw new \InvalidArgumentException('Expected \Domain\Monster\Monster');
        }

        $params[C::TITLE] = 'Monstre : ' . $entity->identity()->getFullName();
        $params[C::TYPE] = C::EDIT;
        $params[C::CSSCLASS] = 'pt-3';
        $params['cancelUrl'] = UrlGenerator::admin(C::ONG_COMPENDIUM, C::MONSTERS);
        $form = $this->createForm($params);

        $cpt = 1;
        foreach ($this->sections as $sectionClass => $title) {
            $fieldset = new FieldsetField(
                $title,
                false,
                [
                    C::CSSCLASS => 'monster-fieldset row mb-4 ' . B::MT5 . ' ' . ($cpt == 1 ? 'active' : '')
                ]
            );
            $section = new $sectionClass($this->readerFactory);
            $section->addFields($fieldset, $entity);
            $form->addField($fieldset);
            $cpt++;
        }

        return $form;
    }

    protected function createForm(array $params = []): Form
    {
        $formAttributes = [
            C::CSSCLASS  => implode(' ', [
                B::MX_AUTO,
                B::MY4,
                $params[C::CSSCLASS] ?? '',
            ]),
            C::TITLE  => $params[C::TITLE],
            C::ACTION => $params[C::ACTION] ?? '',
        ];

        $form = (new Form(
            new TemplateRenderer(),
            $formAttributes
        ));

        $form->addCancel($params['cancelUrl']);
        $form->addButton('Précédent', 'button', [C::CSSCLASS => 'btn btn-sm btn-info', C::ID => 'btnPrev']);
        $form->addButton('Suivant', 'button', [C::CSSCLASS => 'btn btn-sm btn-info', C::ID => 'btnNext']);
        // Boutons par défaut selon le type
        switch ($params[C::TYPE] ?? C::NEW) {
            case C::EDIT:
                $form->addButton('Modifier', 'submit', [C::CSSCLASS => 'btn btn-sm btn-primary']);
                break;
            case C::DELETE:
                $form->addButton('Supprimer', 'submit', [C::CSSCLASS => 'btn btn-sm btn-danger']);
                break;
            case C::NEW:
            default:
                $form->addButton('Créer', 'submit', [C::CSSCLASS => 'btn btn-sm btn-success']);
                break;
        }

        return $form;
    }
}
