<?php
namespace src\Action;

use src\Controller\RpgFeat;
use src\Utils\Session;
use Wp_Post;

class FeatCard
{
    public static function build(): string
    {
        $postId = Session::fromPost('postId');
        $objWpPost = get_post($postId);
        if ($objWpPost instanceof WP_Post) {
            $controller = new RpgFeat();
            return $controller->getCard($objWpPost);
        } else {
            $controller = new RpgFeat();
            return $controller->getCard($postId);
        }
    }
}
