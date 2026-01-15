<?php
namespace src\Controller\Public;

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
