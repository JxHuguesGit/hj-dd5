<?php
namespace src\Controller;

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
