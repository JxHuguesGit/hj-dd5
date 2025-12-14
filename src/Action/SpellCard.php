<?php
namespace src\Action;

use src\Factory\SpellFactory;
use src\Utils\Session;

class SpellCard
{
    const HTML_EXTENSION = '.html';

    public static function build(): string
    {
        $id = Session::fromPost('id');
        
        $post = get_post($id);
        if (!$post || $post->post_type !== 'post') {
            // On vérifie que le post existe et correspond au bon type
            return "L'identifiant passé en paramètre ne correspond à aucun article.";
        }
        // Facultatif : s'assurer qu’il appartient à la catégorie "sort"
        if (!has_category('sort', $post)) {
            return "L'identifiant passé en paramètre ne correspond pas à un article de la catégorie Sort.";
        }

        $rpgSpell = SpellFactory::fromWpPost($post);
        return $rpgSpell->getController()->getSpellCard();
    }

}
