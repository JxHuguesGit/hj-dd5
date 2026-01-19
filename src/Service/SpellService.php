<?php
namespace src\Service;

use src\Collection\Collection;
use src\Constant\Constant;
use src\Constant\Field;
use src\Domain\Skill as DomainSkill;
use src\Factory\SpellFactory;
use src\Repository\SubSkillRepository;

final class SpellService
{
    public function __construct(
        private WpPostService $wpService,
    ) {}

    public function allSpells(): Collection
    {
        $collection = new Collection();

        $args = [
            'post_type'      => 'post',
            'posts_per_page' => 10,
            'category_name'  => 'sort',
            'orderby'        => 'title',
            'order'          => 'ASC',
        ];

        $query = new \WP_Query($args);
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $post = get_post();
                $rpgSpell = SpellFactory::fromWpPost($post);
                $collection->addItem($rpgSpell);
            }
            wp_reset_postdata();
        }

        return $collection;
    }
}
