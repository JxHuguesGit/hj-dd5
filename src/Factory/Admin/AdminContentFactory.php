<?php
namespace src\Factory\Admin;

use src\Constant\Constant as C;
use src\Controller\Admin\AdminCharacterContent;
use src\Controller\Admin\AdminCompendiumContent;
use src\Controller\Admin\AdminHomeContent;
use src\Controller\Admin\AdminMapAdministration;
use src\Controller\Admin\AdminMapContent;
use src\Controller\Admin\AdminMapEditContent;
use src\Controller\Admin\AdminMapNewContent;
use src\Controller\Admin\AdminMapView;
use src\Controller\Admin\AdminTimelineContent;
use src\Factory\CompendiumFactory;
use src\Factory\PresenterFactory;
use src\Factory\ReaderFactory;
use src\Factory\ServiceFactory;
use src\Factory\WriterFactory;
use src\Presenter\Admin\MapAdminPresenter;
use src\Presenter\Admin\MapTokenAdminPresenter;
use src\Presenter\Admin\TokenAdminPresenter;
use src\Presenter\FormBuilder\MapFormBuilder;
use src\Renderer\TemplateRenderer;

final class AdminContentFactory
{
    public function __construct(
        private CompendiumFactory $compendiumFactory,
        private ServiceFactory $serviceFactory,
        private ReaderFactory $readerFactory,
        private WriterFactory $writerFactory,
        private PresenterFactory $presenterFactory,
    ) {}

    public function create(array $arrUri): object
    {
        $onglet = $arrUri[C::ONGLET];
        $id     = $arrUri[C::ID];
        $mapId  = $arrUri[C::MAPID] ?? null;

        return match ($onglet) {
            C::ONG_CHARACTER  => new AdminCharacterContent(),
            C::ONG_TIMELINE   => new AdminTimelineContent(
                $mapId,
                $this->readerFactory->map(),
                $this->readerFactory->initiative(),
                $this->readerFactory->mapToken(),
                $this->presenterFactory->initiative()
            ),
            C::ONG_MAP        => new AdminMapContent(
                $id,
                $mapId,
                $this->readerFactory->map(),
                $this->writerFactory->map(),
                $this->presenterFactory->map(),
                new AdminMapAdministration(
                    $this->serviceFactory->mapToken(),
                    $this->presenterFactory->mapToken(),
                    $this->readerFactory->token(),
                    $this->presenterFactory->token(),
                    $this->readerFactory->map()
                ),
                new AdminMapView(
                    new TemplateRenderer()
                ),
                new AdminMapEditContent(
                    new MapFormBuilder()
                ),
                new AdminMapNewContent(
                    new MapFormBuilder()
                ),
                $this->readerFactory->token(),
                $this->presenterFactory->token(),
            ),
            C::ONG_COMPENDIUM => new AdminCompendiumContent(
                $this->compendiumFactory,
                $id
            ),
            default           => new AdminHomeContent(),
        };
    }
}
