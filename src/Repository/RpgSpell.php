<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Entity\RpgSpell as EntityRpgSpell;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;

class RpgSpell extends Repository
{
    public function __construct(
        protected QueryBuilder $builder,
        protected QueryExecutor $executor
    ) {
    
    }

    public function findAll(array $orderBy=[]): Collection
    {
        $collection = new Collection();

        $args = [
            'post_type'      => 'post',
            'posts_per_page' => 10,
            'paged'          => get_query_var('paged') ?: 1,
            'category_name'  => 'sort',
            'orderby'        => 'title',
            'order'          => 'ASC',
        ];
        
        $query = new \WP_Query($args);
        if ($query->have_posts()) :
            while ($query->have_posts()) {
                $query->the_post();
                $post = get_post();
                $rpgSpell = new EntityRpgSpell($post);
                $collection->addItem($rpgSpell);
            }
            wp_reset_postdata();
        endif;



        return $collection;
    }

}
