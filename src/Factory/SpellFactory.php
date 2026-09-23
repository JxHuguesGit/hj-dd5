<?php
namespace src\Factory;

use src\Domain\Entity\Spell;
use src\Service\Reader\SpellReader;

class SpellFactory
{
    public static function fromWpPost(
        SpellReader $spellReader,
        \WP_Post $post
    ): Spell
    {
        $spell = $spellReader->spellByWpPostId($post->ID);
        // Ajout des éléments relatifs au post WordPress
        $spell->name = $post->post_title;
        $spell->slug = $post->post_name;
        $spell->description = apply_filters('the_content', $post->post_content);

        return $spell;
    }
}
