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
    		'post_type'      => 'post',          // ou 'sort' si tu fais un CPT
    		'posts_per_page' => -1,              // pagination
    		'category_name'  => 'sort',         // le slug de ta catégorie
    		'orderby'        => 'title',
    		'order'          => 'ASC',
    		'meta_query'     => [
            	/*
            	'relation' => 'AND',
        		[
            		'key'     => 'rituel',
		            'value'   => '"r"',
        		    'compare' => 'LIKE',
        		],
        		[
            		'key'     => 'concentration',
		            'value'   => '"c"',
        		    'compare' => 'LIKE',
        		],
        		[
            		'key'     => 'niveau',
		            'value'   => '1',
        		    'compare' => '=',
        		],
        		[
            		'key'     => 'ecole',
		            'value'   => 'nécromancie',
        		    'compare' => '=',
        		],
        		[
            		'key'     => 'temps_dincantation',
		            'value'   => 'reaction',
        		    'compare' => '=',
        		],
                */
        		[
            		'key'     => 'niveau',
		            'value'   => '1',
        		    'compare' => '=',
        		],
            ],
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
