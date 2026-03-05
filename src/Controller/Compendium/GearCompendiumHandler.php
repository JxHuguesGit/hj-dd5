<?php
namespace src\Controller\Compendium;

use src\Constant\Constant as C;
use src\Constant\Language as L;
use src\Domain\Entity\Item;
use src\Domain\Validator\ItemValidator;
use src\Factory\ItemFactory;
use src\Page\PageForm;
use src\Page\PageList;
use src\Presenter\FormBuilder\GearFormBuilder;
use src\Presenter\ListPresenter\GearListPresenter;
use src\Presenter\TableBuilder\ItemTableBuilder;
use src\Presenter\ToastBuilder;
use src\Renderer\TemplateRenderer;
use src\Service\Reader\ItemReader;
use src\Service\Writer\ItemWriter;
use src\Utils\Session;

final class GearCompendiumHandler implements CompendiumHandlerInterface
{
    private string $toastContent = '';

    public function __construct(
        private ItemWriter $itemWriter,
        private ItemReader $itemReader,
        private ToastBuilder $toastBuilder,
        private TemplateRenderer $templateRenderer
    ) {}

    public function render(): string
    {
        $action = Session::fromGet(C::ACTION);
        $slug   = Session::fromGet(C::SLUG);

        if (Session::isPostSubmitted()) {
            return $this->handleSubmit($action, $slug);
        }

        $newItem       = ItemFactory::createEmpty();
        $newItem->type = 'other';

        return match (true) {
            $action === C::EDIT && $slug !== ''  => $this->renderEdit($slug),
            $action === C::DELETE && $slug != '' => $this->renderDelete($slug),
            $action === C::NEW                   => $this->renderCreate($newItem),
            default                              => $this->renderList(),
        };
    }

    private function handleSubmit(string $action, string $slug): string
    {
        return match ($action) {
            C::EDIT => $this->handleEditSubmit($slug),
            C::NEW  => $this->handleNewSubmit(),
            default => $this->renderList(),
        };
    }

    private function handleNewSubmit(): string
    {
        $item = ItemFactory::fromPost();
        if ($item->type == 'Autre') {
            $item->type = 'other';
        }

        $errors = ItemValidator::validate($item);
        if (! empty($errors)) {
            $this->toastContent = $this->toastBuilder->error("Le formulaire contient des erreurs : " . implode(', ', $errors));
            return $this->renderCreate($item);
        }

        $this->itemWriter->insert($item);
        $this->toastContent = $this->toastBuilder->success("L'objet <strong>" . $item->name . "</strong> a été correctement créé.");
        return $this->renderList();
    }

    private function handleEditSubmit(string $slug): string
    {
        $item = $this->itemReader->itemBySlug($slug, null);
        $view = null;

        if (! $item) {
            $this->toastContent = $this->toastBuilder->error(L::UNKNOWN_ENTRY);
            $view               = $this->renderList($slug);
        } else {
            $changedFields = [];
            foreach (Item::EDITABLE_FIELDS as $field) {
                $value = Session::fromPost($field, 'err');
                $value = str_replace("\\'", "'", $value);
                if ($value != 'err' && $item->$field != $value) {
                    $item->$field    = $value;
                    $changedFields[] = $field;
                }
            }

            if (! empty($changedFields)) {
                $errors = ItemValidator::validate($item);
                if (! empty($errors)) {
                    $this->toastContent = $this->toastBuilder->error(sprintf(L::FORM_ERROR, implode(', ', $errors)));
                    $view               = $this->renderEdit($slug);
                } else {
                    // On sauvegarde le changement
                    $this->itemWriter->updatePartial($item, $changedFields);
                    $this->toastContent = $this->toastBuilder->success(sprintf(L::SUCCESS_EDIT_ENTRY, $item->name));
                    $view               = $this->renderList();
                }
            } else {
                $this->toastContent = $this->toastBuilder->info(L::NO_MODIFICATION_ENTRY);
                $view               = $this->renderEdit($slug);
            }
        }
        return $view;
    }

    private function renderCreate(Item $item): string
    {
        $page = new PageForm(
            $this->templateRenderer,
            new GearFormBuilder(C::NEW ),
            $this->toastContent
        );

        return $page->renderAdmin('', $item);
    }

    private function renderEdit(string $slug): string
    {
        $item = $this->itemReader->itemBySlug($slug, null);

        $page = new PageForm(
            $this->templateRenderer,
            new GearFormBuilder(),
            $this->toastContent
        );

        return $page->renderAdmin('', $item);
    }

    public function renderList(): string
    {
        $items     = $this->itemReader->allGears();
        $presenter = new GearListPresenter();
        $content   = $presenter->present($items);
        $page      = new PageList(
            $this->templateRenderer,
            new ItemTableBuilder(true)
        );
        return $page->renderAdmin('', $content, $this->toastContent);
    }

    public function renderDelete(string $slug): string
    {
        $item = $this->itemReader->itemBySlug($slug, null);
        if (! $item) {
            $this->toastContent = $this->toastBuilder->error(L::UNKNOWN_ENTRY);
        } else {
            $this->toastContent = $this->toastBuilder->success(sprintf(L::SUCCESS_DEL_ENTRY, $item->name));
            // TODO : Supprimer l'objet dans les table de jointures
            $this->itemWriter->delete($item);
        }

        return $this->renderList();
    }
}
