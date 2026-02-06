<?php
namespace src\Controller\Compendium;

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
        $qb = new QueryBuilder();
        $qe = new QueryExecutor();
        $repository = new FeatRepository($qb, $qe);
        $criteria = new FeatCriteria();
        $templateRender = new TemplateRenderer();
        $toastBuilder = new ToastBuilder($templateRender);
        $criteria->slug = $slug;

        $feat = $repository->findAllWithCriteria($criteria)?->first();
        if (!$feat) {
            $this->toastContent = $toastBuilder->error('Échec', "Le don modifié n'existe pas.");
            return $this->renderList($slug);
        }

        if ($action === Constant::EDIT) {
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
                $repository->updatePartial($feat, $changedFields);
                $this->toastContent = $toastBuilder->success('Réussite', "Le don <strong>".$feat->name."</strong> a été correctement mis à jour.");
                return $this->renderList($slug);
            } else {
                $this->toastContent = $toastBuilder->info('Information', "Aucune valeur n'a été modifiée pour être enregistrée.");
                return $this->renderEdit($slug);
            }
        } else {
            // Action pas encore prévue.
        }

        // Par défaut. On verra plus tard quand ça fonctionnera bien.
        return $this->renderList($slug);
    }

    private function renderEdit(string $slug): string
    {
        $qb = new QueryBuilder();
        $qe = new QueryExecutor();
        $repository = new FeatRepository($qb, $qe);
        $reader = new FeatReader($repository);
        
        $feat = $reader->featBySlug($slug);
        // méthode à ajouter dans FeatReader
        $page = new PageForm(
            new TemplateRenderer(),
            new FeatFormBuilder(
                new WpPostService()
            ),
            $this->toastContent
        );
        
        return $page->renderAdmin('', $feat);
    }

    private function renderList(): string
    {
        $qb = new QueryBuilder();
        $qe = new QueryExecutor();
        $originRepo = new OriginRepository($qb, $qe);
        $repository = new FeatRepository($qb, $qe);
        $reader = new FeatReader($repository);

        $feats = $reader->allFeats([
            Field::FEATTYPEID => Constant::CST_ASC,
            Field::NAME       => Constant::CST_ASC
        ]);

        $presenter = new FeatListPresenter(
            new OriginReader($originRepo),
            new WpPostService()
        );
        $presentContent = $presenter->present($feats);

        $page = new PageList(
            new TemplateRenderer(),
            new FeatTableBuilder(true)
        );

        return $page->renderAdmin('', $presentContent, $this->toastContent);
    }
}

