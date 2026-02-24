<?php
namespace src\Service\Ajax;

use src\Constant\Constant;
use src\Factory\Controller\OriginControllerFactory;
use src\Factory\ReaderFactory;
use src\Factory\ServiceFactory;
use src\Renderer\TemplateRenderer;

class CharacterCreationAjax
{
    public function __construct(
        private ReaderFactory $readerFactory,
        private ServiceFactory $serviceFactory,
        private TemplateRenderer $renderer
    ) {}

    public function loadCreationStepSide(string $type, int $id): array
    {
        switch ($type) {
            case Constant::ORIGIN :
                $reader = $this->readerFactory->origin();
                $origin = $reader->originById($id);
                if (!$origin) {
                    $returned = [
                        'html' => 'Une erreur est survenue durant le chargement. <strong>' .
                            $type . '</strong> n\'a aucun élément qui correspond à l\'identifiant <strong>' .
                            $id . '</strong>.'
                    ];
                } else {
                    $detail = new OriginControllerFactory($this->readerFactory, $this->serviceFactory, $this->renderer);
                    $publicBase = $detail->createDetailController($origin->slug);
                    $viewData = $publicBase->getViewData();
                    $returned = [
                        'html' => $viewData['description'],
                    ];
                }
            break;
            default :
                $returned = [
                    'html' => 'Une erreur est survenue durant le chargement. <strong>' .
                        $type . '</strong> n\'est pas défini pour cette action.'
                ];
            break;
        }
        return $returned;
    }

}
/*
        case 'feat' :
            $obj = new RepositoryRpgFeat(Entity::$qb, Entity::$qe);
            $origin = $obj->find($id);
            $returned = $origin->getController()->getDescription();
*/
