<?php
namespace src\Presenter\FormBuilder;

use src\Constant\Bootstrap as B;
use src\Constant\Constant as C;
use src\Renderer\TemplateRenderer;
use src\Utils\Form;

abstract class AbstractFormBuilder implements FormBuilderInterface
{
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
        // Boutons par défaut selon le type
        switch ($params[C::TYPE] ?? C::NEW ) {
            case C::EDIT:
                $form->addButton('Modifier', 'submit', [C::CSSCLASS => 'btn btn-sm btn-primary']);
                break;
            case C::DELETE:
                $form->addButton('Supprimer', 'submit', [C::CSSCLASS => 'btn btn-sm btn-danger']);
                break;
            case C::NEW :
            default:
                $form->addButton('Créer', 'submit', [C::CSSCLASS => 'btn btn-sm btn-success']);
                break;
        }

        return $form;
    }
}
