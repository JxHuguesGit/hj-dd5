<?php
namespace src\Controller\Compendium;

use src\Constant\Constant;
use src\Domain\Criteria\ItemCriteria;
use src\Domain\Item;
use src\Domain\Validator\ItemValidator;
use src\Factory\ItemFactory;
use src\Page\PageForm;
use src\Page\PageList;
use src\Presenter\FormBuilder\GearFormBuilder;
use src\Presenter\ListPresenter\GearListPresenter;
use src\Presenter\TableBuilder\ItemTableBuilder;
use src\Presenter\ToastBuilder;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Renderer\TemplateRenderer;
use src\Repository\ItemRepository;
use src\Service\Reader\ItemReader;
use src\Utils\Session;

final class GearCompendiumHandler implements CompendiumHandlerInterface
{
    private string $toastContent = '';

    public function render(): string
    {
        $action = Session::fromGet(Constant::CST_ACTION);
        $slug   = Session::fromGet(Constant::CST_SLUG);

        if (Session::isPostSubmitted()) {
            return $this->handleSubmit($action, $slug);
        }

        if ($action === Constant::EDIT && $slug!=='') {
            return $this->renderEdit($slug);
        } elseif ($action === Constant::NEW) {
            $item = ItemFactory::createEmpty();
            return $this->renderCreate($item);
        } else {
            return $this->renderList();
        }
    }

    private function handleSubmit(string $action, string $slug): string
    {
        $qb = new QueryBuilder();
        $qe = new QueryExecutor();
        $repository = new ItemRepository($qb, $qe);
        $reader = new ItemReader($repository);
        $templateRender = new TemplateRenderer();
        $toastBuilder = new ToastBuilder($templateRender);

        if ($action === Constant::EDIT) {
            $item = $reader->itemBySlug($slug);
            if (!$item) {
                $this->toastContent = $toastBuilder->error('Échec', "L'objet modifié n'existe pas.");
                return $this->renderList($slug);
            }

            $changedFields = [];
            foreach (Item::EDITABLE_FIELDS as $field) {
                $value = Session::fromPost($field, 'err');
                if ($value != 'err' && $item->$field != $value) {
                    $item->$field = $value;
                    $changedFields[] = $field;
                }
            }

            if (!empty($changedFields)) {
                // On sauvegarde le changement
                $repository->updatePartial($item, $changedFields);
                $this->toastContent = $toastBuilder->success('Réussite', "L'objet <strong>".$item->name."</strong> a été correctement mis à jour.");
                return $this->renderList($slug);
            } else {
                $this->toastContent = $toastBuilder->info('Information', "Aucune valeur n'a été modifiée pour être enregistrée.");
                return $this->renderEdit($slug);
            }
        } elseif ($action === Constant::NEW) {
            $item = ItemFactory::fromPost();
            $errors = ItemValidator::validate($item);
            if (!empty($errors)) {
                $this->toastContent = $toastBuilder->error( 'Échec', "Le formulaire contient des erreurs : " . implode(', ', $errors) );
                return $this->renderCreate($item);
            }
            
            $repository->insert($item);
            $this->toastContent = $toastBuilder->success('Réussite', "L'objet <strong>".$item->name."</strong> a été correctement créé.");
            return $this->renderList($slug);
    } else {
            // Action pas encore prévue.
        }

        // Par défaut. On verra plus tard quand ça fonctionnera bien.
        return $this->renderList($slug);
    }

    private function renderCreate(Item $item): string
    {
        $page = new PageForm(
            new TemplateRenderer(),
            new GearFormBuilder(Constant::NEW),
            $this->toastContent
        );
        
        return $page->renderAdmin('', $item);
    }

    private function renderEdit(string $slug): string
    {
        $qb = new QueryBuilder();
        $qe = new QueryExecutor();
        $repository = new ItemRepository($qb, $qe);
        $reader = new ItemReader($repository);

        $item = $reader->itemBySlug($slug);

        $page = new PageForm(
            new TemplateRenderer(),
            new GearFormBuilder(),
            $this->toastContent
        );
        
        return $page->renderAdmin('', $item);
    }

    public function renderList(): string
    {
        $qb = new QueryBuilder();
        $qe = new QueryExecutor();
        $repository = new ItemRepository($qb, $qe);

        $gears = $repository->findAllWithItemAndType(
            new ItemCriteria()
        );

        $presenter = new GearListPresenter();
        $content   = $presenter->present($gears);

        $page = new PageList(
            new TemplateRenderer(),
            new ItemTableBuilder(true)
        );

        return $page->renderAdmin('', $content, $this->toastContent);
    }
}
