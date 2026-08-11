<?php
namespace src\Factory\Admin;

use src\Constant\Constant as C;
use src\Controller\Admin\AdminCharacterContent;
use src\Controller\Admin\AdminCompendiumContent;
use src\Controller\Admin\AdminHomeContent;
use src\Controller\Admin\AdminMapAdministration;
use src\Controller\Admin\AdminMapContent;
use src\Controller\Admin\AdminMapView;
use src\Controller\Admin\AdminTimelineContent;
use src\Factory\CompendiumFactory;
use src\Factory\ReaderFactory;
use src\Factory\ServiceFactory;
use src\Presenter\Admin\MapAdminPresenter;
use src\Presenter\Admin\MapTokenAdminPresenter;
use src\Presenter\Admin\TokenAdminPresenter;
use src\Renderer\TemplateRenderer;

final class AdminContentFactory
{
    public function __construct(
        private CompendiumFactory $compendiumFactory,
        private ServiceFactory $serviceFactory,
        private ReaderFactory $readerFactory,
    ) {}

    public function create(array $arrUri): object
    {
        $onglet = $arrUri[C::ONGLET];
        $id     = $arrUri[C::ID];
        $mapId  = $arrUri[C::MAPID] ?? null;

        return match ($onglet) {
            C::ONG_CHARACTER  => new AdminCharacterContent(),
            C::ONG_TIMELINE   => new AdminTimelineContent(),
            C::ONG_MAP        => new AdminMapContent(
                $mapId,
                $this->readerFactory->map(),
                new MapAdminPresenter(
                    new TemplateRenderer()
                ),
                new AdminMapAdministration(
                    $this->serviceFactory->mapToken(),
                    new MapTokenAdminPresenter(
                        new TemplateRenderer()
                    ),
                    $this->readerFactory->token(),
                    new TokenAdminPresenter(
                        new TemplateRenderer()
                    ),
                    $this->readerFactory->map()
                ),
                new AdminMapView(
                    new TemplateRenderer()
                )
            ),
            C::ONG_COMPENDIUM => new AdminCompendiumContent(
                $this->compendiumFactory,
                $id
            ),
            default           => new AdminHomeContent(),
        };
    }
}
