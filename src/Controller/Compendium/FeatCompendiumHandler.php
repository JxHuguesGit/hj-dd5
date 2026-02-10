<?php
namespace src\Controller\Compendium;

use ParagonIE\Sodium\Core\Curve25519\Fe;
use src\Constant\Constant;
use src\Constant\Field;
use src\Domain\Criteria\FeatCriteria;
use src\Domain\Feat;
use src\Page\PageForm;
use src\Page\PageList;
use src\Presenter\FormBuilder\FeatFormBuilder;
use src\Presenter\ListPresenter\FeatListPresenter;
use src\Presenter\TableBuilder\FeatTableBuilder;
use src\Presenter\ToastBuilder;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Renderer\TemplateRenderer;
use src\Repository\FeatRepository;
use src\Repository\OriginRepository;
use src\Service\Domain\WpPostService;
use src\Service\Reader\FeatReader;
use src\Service\Reader\OriginReader;
use src\Utils\Session;

class FeatCompendiumHandler implements CompendiumHandlerInterface
{
    private string $toastContent = '';

    public function __construct(
        private FeatRepository $featRepository,
        private FeatReader $featReader,
        private OriginReader $originReader,
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

        return match(true) {
            $action === Constant::EDIT && $slug !== '' => $this->renderEdit($slug),
            //$action === Constant::NEW => $this->renderCreate(new Item()),
            default => $this->renderList(),
        };
    }

    private function handleSubmit(string $action, string $slug): string
    {
        return match ($action) {
            Constant::EDIT => $this->handleEditSubmit($slug),
            //Constant::NEW  => $this->handleNewSubmit(),
            default        => $this->renderList(),
        };
    }

    private function handleEditSubmit(string $slug): string
    {
        $criteria = new FeatCriteria();
        $criteria->slug = $slug;
        $feat = $this->featRepository->findAllWithCriteria($criteria)?->first();
        if (!$feat) {
            $this->toastContent = $this->toastBuilder->error("Le don modifié n'existe pas.");
            return $this->renderList($slug);
        }

        $changedFields = [];
        foreach (Feat::EDITABLE_FIELDS as $field) {
            $value = Session::fromPost($field, 'err');
            if ($value != 'err' && $feat->$field != $value) {
                $feat->$field = $value;
                $changedFields[] = $field;
            }
        }

        if (!empty($changedFields)) {
            // On sauvegarde le changement
            $this->featRepository->updatePartial($feat, $changedFields);
            $this->toastContent = $this->toastBuilder->success("Le don <strong>".$feat->name."</strong> a été correctement mis à jour.");
            return $this->renderList($slug);
        } else {
            $this->toastContent = $this->toastBuilder->info("Aucune valeur n'a été modifiée pour être enregistrée.");
            return $this->renderEdit($slug);
        }
    }

    private function renderEdit(string $slug): string
    {
        $feat = $this->featReader->featBySlug($slug);

        $page = new PageForm(
            $this->templateRenderer,
            new FeatFormBuilder(
                new WpPostService()
            ),
            $this->toastContent
        );
        
        return $page->renderAdmin('', $feat);
    }

    private function renderList(): string
    {
        $feats = $this->featReader->allFeats([
            Field::FEATTYPEID => Constant::CST_ASC,
            Field::NAME       => Constant::CST_ASC
        ]);

        $presenter = new FeatListPresenter(
            $this->originReader,
            new WpPostService()
        );
        $presentContent = $presenter->present($feats);

        $page = new PageList(
            $this->templateRenderer,
            new FeatTableBuilder(true)
        );

        return $page->renderAdmin('', $presentContent, $this->toastContent);
    }
}

