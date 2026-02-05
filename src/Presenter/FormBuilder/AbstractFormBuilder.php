<?php
namespace src\Presenter\FormBuilder;

use src\Utils\Form;
use src\Constant\Bootstrap;
use src\Constant\Constant;
use src\Renderer\TemplateRenderer;
use src\Utils\Html;

abstract class AbstractFormBuilder implements FormBuilderInterface
{
    protected function createForm(array $params = []): Form
    {
        $formAttributes = [
            Constant::CST_CLASS => implode(' ', [
                Bootstrap::CSS_MX_AUTO,
                Bootstrap::CSS_MY4,
                $params[Constant::CST_CLASS] ?? ''
            ]),
            Constant::CST_TITLE => $params[Constant::CST_TITLE],
        ];

        $form = (new Form(
            new TemplateRenderer(),
            $formAttributes
        ));

        $form->addCancel($params['cancelUrl']);
        // Boutons par défaut selon le type
        switch ($params['type'] ?? 'new') {
            case 'edit':
                $form->addButton('Modifier', 'submit', ['class' => 'btn btn-sm btn-primary']);
                break;
            case 'delete':
                $form->addButton('Supprimer', 'submit', ['class' => 'btn btn-sm btn-danger']);
                break;
            case 'new':
            default:
                $form->addButton('Créer', 'submit', ['class' => 'btn btn-sm btn-success']);
                break;
        }

        return $form;
    }
}
