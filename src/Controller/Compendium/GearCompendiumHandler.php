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
use src\Renderer\TemplateRenderer;
use src\Repository\ItemRepository;
use src\Service\Reader\ItemReader;
use src\Utils\Session;

final class GearCompendiumHandler implements CompendiumHandlerInterface
{
    private string $toastContent = '';

    public function __construct(
        private ItemRepository $itemRepository,
        private ItemReader $itemReader,
        private ToastBuilder $toastBuilder,
        private TemplateRenderer $templateRenderer
    ) {}

    public function render(): string
    {
        $action = Session::fromGet(Constant::CST_ACTION);
        $slug   = Session::fromGet(Constant::CST_SLUG);

        if (Session::isPostSubmitted()) {
            return $this->handleSubmit($action, $slug);
        }

        $newItem = ItemFactory::createEmpty();
        $newItem->type = 'other';

        return match(true) {
            $action === Constant::EDIT && $slug !== '' => $this->renderEdit($slug),
            $action === Constant::NEW => $this->renderCreate($newItem),
            default => $this->renderList(),
        };
    }

    private function handleSubmit(string $action, string $slug): string
    {
        return match ($action) {
            Constant::EDIT => $this->handleEditSubmit($slug),
            Constant::NEW  => $this->handleNewSubmit(),
            default        => $this->renderList(),
        };
    }

    private function handleNewSubmit(): string
    {
            $item = ItemFactory::fromPost();
            if ($item->type=='Autre') {
                $item->type = 'other';
            }
        
            $errors = ItemValidator::validate($item);
            if (!empty($errors)) {
                $this->toastContent = $this->toastBuilder->error("Le formulaire contient des erreurs : " . implode(', ', $errors));
                return $this->renderCreate($item);
            }

            $this->itemRepository->insert($item);
            $this->toastContent = $this->toastBuilder->success("L'objet <strong>".$item->name."</strong> a été correctement créé.");
            return $this->renderList();
    }

    private function handleEditSubmit(string $slug): string
    {
        $item = $this->itemReader->itemBySlug($slug);
        if (!$item) {
            $this->toastContent = $this->toastBuilder->error("L'objet modifié n'existe pas.");
            return $this->renderList($slug);
        }

        $changedFields = [];
        foreach (Item::EDITABLE_FIELDS as $field) {
            $value = Session::fromPost($field, 'err');
            $value = str_replace("\\'", "'", $value);
            if ($value != 'err' && $item->$field != $value) {
                $item->$field = $value;
                $changedFields[] = $field;
            }
        }

        if (!empty($changedFields)) {
            $errors = ItemValidator::validate($item);
            if (!empty($errors)) {
                $this->toastContent = $this->toastBuilder->error("Le formulaire contient des erreurs : " . implode(', ', $errors));
                return $this->renderEdit($slug);
            }
            // On sauvegarde le changement
            $this->itemRepository->updatePartial($item, $changedFields);
            $this->toastContent = $this->toastBuilder->success("L'objet <strong>".$item->name."</strong> a été correctement mis à jour.");
            return $this->renderList();
        } else {
            $this->toastContent = $this->toastBuilder->info("Aucune valeur n'a été modifiée pour être enregistrée.");
            return $this->renderEdit($slug);
        }
    }

    private function renderCreate(Item $item): string
    {
        $page = new PageForm(
            $this->templateRenderer,
            new GearFormBuilder(Constant::NEW),
            $this->toastContent
        );
        
        return $page->renderAdmin('', $item);
    }

    private function renderEdit(string $slug): string
    {
        $item = $this->itemReader->itemBySlug($slug);

        $page = new PageForm(
            $this->templateRenderer,
            new GearFormBuilder(),
            $this->toastContent
        );
        
        return $page->renderAdmin('', $item);
    }

    public function renderList(): string
    {
        $items = $this->itemRepository->findAllWithItemAndType(
            new ItemCriteria()
        );

        $presenter = new GearListPresenter();
        $content   = $presenter->present($items);

        $page = new PageList(
            $this->templateRenderer,
            new ItemTableBuilder(true)
        );

        return $page->renderAdmin('', $content, $this->toastContent);
    }
}
