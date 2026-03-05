<?php
namespace src\Presenter\FormBuilder;

use src\Constant\Bootstrap as B;
use src\Constant\Constant;
use src\Renderer\TemplateRenderer;
use src\Utils\Form;

abstract class AbstractFormBuilder implements FormBuilderInterface
{
    protected function createForm(array $params = []): Form
    {
        $formAttributes = [
            Constant::CSSCLASS  => implode(' ', [
                B::MX_AUTO,
                B::MY4,
                $params[Constant::CSSCLASS] ?? '',
            ]),
            Constant::TITLE  => $params[Constant::TITLE],
            Constant::ACTION => $params[Constant::ACTION] ?? '',
        ];

        $form = (new Form(
            new TemplateRenderer(),
            $formAttributes
        ));

        $form->addCancel($params['cancelUrl']);
        // Boutons par défaut selon le type
        switch ($params[Constant::TYPE] ?? Constant::NEW ) {
            case Constant::EDIT:
                $form->addButton('Modifier', 'submit', [Constant::CSSCLASS => 'btn btn-sm btn-primary']);
                break;
            case Constant::DELETE:
                $form->addButton('Supprimer', 'submit', [Constant::CSSCLASS => 'btn btn-sm btn-danger']);
                break;
            case Constant::NEW :
            default:
                $form->addButton('Créer', 'submit', [Constant::CSSCLASS => 'btn btn-sm btn-success']);
                break;
        }

        return $form;
    }
}
