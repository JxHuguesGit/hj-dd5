<?php
namespace src\Presenter\Detail;

use src\Constant\Field as F;
use src\Presenter\ViewModel\PageViewInterface;

class ToolDetailPresenter extends AbstractItemDetailPresenter
{
    public function present(PageViewInterface $viewData): array
    {
        /** @var PageViewInterface $viewData */
        $base = parent::present($viewData);
        $base[F::PARENTNAME]         = $viewData->item->parentName;
        return $base;
    }
}
