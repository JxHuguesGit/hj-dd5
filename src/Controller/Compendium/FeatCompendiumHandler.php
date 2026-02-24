<?php
namespace src\Controller\Compendium;

use src\Domain\Entity\Feat;
use src\Page\PageForm;
use src\Page\PageList;
use src\Presenter\FormBuilder\FeatFormBuilder;
use src\Presenter\ListPresenter\FeatListPresenter;
use src\Presenter\TableBuilder\FeatTableBuilder;
use src\Presenter\ToastBuilder;
use src\Renderer\TemplateRenderer;
use src\Service\Domain\WpPostService;
use src\Service\Reader\FeatReader;
use src\Service\Reader\FeatTypeReader;
use src\Service\Reader\OriginReader;
use src\Service\Writer\FeatWriter;
use src\Utils\Session;

class FeatCompendiumHandler extends AbstractCompendiumHandler implements CompendiumHandlerInterface
{
    private string $toastContent = '';

    public function __construct(
        private FeatWriter $featWriter,
        private FeatReader $featReader,
        private FeatTypeReader $featTypeReader,
        private OriginReader $originReader,
        private ToastBuilder $toastBuilder,
        private TemplateRenderer $templateRenderer
    ) {}

    protected function handleEditSubmit(string $slug): string
    {
        $feat = $this->featReader->featBySlug($slug);
        if (! $feat) {
            $this->toastContent = $this->toastBuilder->error("Le don modifié n'existe pas.");
            return $this->renderList($slug);
        }

        $changedFields = [];
        foreach (Feat::EDITABLE_FIELDS as $field) {
            $value = Session::fromPost($field, 'err');
            if ($value != 'err' && $feat->$field != $value) {
                $feat->$field    = $value;
                $changedFields[] = $field;
            }
        }

        if (! empty($changedFields)) {
            // On sauvegarde le changement
            $this->featWriter->updatePartial($feat, $changedFields);
            $this->toastContent = $this->toastBuilder->success("Le don <strong>" . $feat->name . "</strong> a été correctement mis à jour.");
            return $this->renderList($slug);
        } else {
            $this->toastContent = $this->toastBuilder->info("Aucune valeur n'a été modifiée pour être enregistrée.");
            return $this->renderEdit($slug);
        }
    }

    protected function renderEdit(string $slug): string
    {
        $feat = $this->featReader->featBySlug($slug);

        $page = new PageForm(
            $this->templateRenderer,
            new FeatFormBuilder(
                new WpPostService(),
                $this->featTypeReader
            ),
            $this->toastContent
        );

        return $page->renderAdmin('', $feat);
    }

    protected function renderList(): string
    {
        $feats     = $this->featReader->allFeats();
        $presenter = new FeatListPresenter(
            $this->originReader,
            new WpPostService()
        );
        $presentContent = $presenter->present($feats);
        $page           = new PageList(
            $this->templateRenderer,
            new FeatTableBuilder(true)
        );
        return $page->renderAdmin('', $presentContent, $this->toastContent);
    }
}
