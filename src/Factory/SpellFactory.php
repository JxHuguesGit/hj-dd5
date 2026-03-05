<?php
namespace src\Factory;

use src\Constant\Constant;
use src\Constant\Field as F;
use src\Domain\Entity\Spell;

class SpellFactory
{
    public static function fromWpPost(\WP_Post $post): Spell
    {
        return new Spell([
            Constant::ID          => $post->ID,
            Constant::NAME        => $post->post_title,
            Constant::SLUG        => $post->post_name,
            Constant::CONTENT     => apply_filters('the_content', $post->post_content),
            'tempsIncantation'        => get_field('temps_dincantation', $post->ID),
            'portee'                  => get_field('portee', $post->ID),
            'duree'                   => get_field('duree', $post->ID),
            F::NIVEAU             => get_field(F::NIVEAU, $post->ID),
            F::SCHOOL             => get_field(F::SCHOOL, $post->ID),
            F::CLASSES            => get_field(F::CLASSES, $post->ID),
            'composantes'             => get_field('composantes', $post->ID),
            'composanteMaterielle'    => get_field('composante_materielle', $post->ID),
            'concentration'           => !empty(get_field('concentration', $post->ID)),
            'rituel'                  => !empty(get_field('rituel', $post->ID)),
            'typeAmelioration'        => self::sanitizeImprovementType(get_field('type_damelioration', $post->ID)),
            'ameliorationDescription' => get_field('amelioration_description', $post->ID)
        ]);
    }

    private static function sanitizeImprovementType($acfField): ?string
    {
        if (empty($acfField)) {
            return null;
        }
        // ACF peut parfois renvoyer un tableau
        return is_array($acfField) ? $acfField[0] : $acfField;
    }
}
