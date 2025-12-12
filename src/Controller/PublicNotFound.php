<?php
namespace src\Controller;

use src\Constant\Constant;
use src\Constant\Field;
use src\Constant\Template;
use src\Entity\Entity;
use src\Exception\NotFoundException;
use src\Factory\RepositoryFactory;
use src\Repository\RpgOrigin as RepositoryRpgOrigin;
use src\Page\PageOrigine;
use src\Presenter\MenuPresenter;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Model\PageRegistry;

class PublicNotFound extends PublicBase
{
    public function getTitle(): string
    {
        return 'Page non trouvée';
    }

    public function getContentPage(): string
    {
        return 'Page non trouvée.';
    }
}
