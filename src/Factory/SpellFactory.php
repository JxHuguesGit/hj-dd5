<?php
namespace src\Factory;

use src\Constant\Constant;
use src\Constant\Field;
use src\Domain\Entity\Spell;

class SpellFactory
{
    public static function fromWpPost(\WP_Post $post): Spell
    {
        return new Spell([
            Constant::CST_ID          => $post->ID,
            Constant::CST_NAME        => $post->post_title,
            Constant::CST_SLUG        => $post->post_name,
            Constant::CST_CONTENT     => apply_filters('the_content', $post->post_content),
            'tempsIncantation'        => get_field('temps_dincantation', $post->ID),
            'portee'                  => get_field('portee', $post->ID),
            'duree'                   => get_field('duree', $post->ID),
            Field::NIVEAU             => get_field(Field::NIVEAU, $post->ID),
            Field::SCHOOL             => get_field(Field::SCHOOL, $post->ID),
            Field::CLASSES            => get_field(Field::CLASSES, $post->ID),
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
