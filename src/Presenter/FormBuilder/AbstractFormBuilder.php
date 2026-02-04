<?php
namespace src\Presenter\FormBuilder;

use src\Utils\Form;
use src\Constant\Bootstrap;
use src\Constant\Constant;
use src\Renderer\TemplateRenderer;

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
            'method' => $params['method'] ?? 'post',
            'action' => $params['action'] ?? ''
        ];

        $form = (new Form(
            new TemplateRenderer(),
            $formAttributes
        ));

        // Boutons par défaut selon le type
        switch ($params['type'] ?? 'new') {
            case 'edit':
                $form->addButton('Annuler', 'reset', ['class' => 'btn btn-secondary']);
                $form->addButton('Modifier', 'submit', ['class' => 'btn btn-primary']);
                break;
            case 'delete':
                $form->addButton('Annuler', 'reset', ['class' => 'btn btn-secondary']);
                $form->addButton('Supprimer', 'submit', ['class' => 'btn btn-danger']);
                break;
            case 'new':
            default:
                $form->addButton('Annuler', 'reset', ['class' => 'btn btn-secondary']);
                $form->addButton('Créer', 'submit', ['class' => 'btn btn-success']);
                break;
        }

        return $form;
    }
}
