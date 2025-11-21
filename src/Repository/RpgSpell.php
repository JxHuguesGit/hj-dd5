<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Entity\RpgSpell as EntityRpgSpell;
use src\Factory\SpellFactory;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;

class RpgSpell extends Repository
{
    public function __construct(
        protected QueryBuilder $builder,
        protected QueryExecutor $executor
    ) {
        parent::__construct(
            $builder,
            $executor,
            '',
            []
        );    
    }
    
    public function findBy(array $criteria, array $orderBy=[], int $limit=-1): Collection
    {
        $collection = new Collection();
        $meta_query = ['relation' => 'AND'];
        
        // Définition du filtre sur le niveau
        $minLevel = $criteria['levelMinFilter'];
        $maxLevel = $criteria['levelMaxFilter'];
        $meta_query[] = [
            'key'     => 'niveau',
            'value'   => [$minLevel, $maxLevel],
            'type'    => 'NUMERIC',
            'compare' => 'BETWEEN',
        ];
        
        // Définition du filtre sur l'école de magie, seulement si on ne les a pas toutes sélectionnées
        if (count($criteria['schoolFilter'])!=8) {
            $meta_query[] = [
                'key'     => 'ecole',
                'value'   => $criteria['schoolFilter'],  // un tableau
                'compare' => 'IN'
            ];
        }
        
        // Définition du filtre sur la classe, seulement si on ne les a pas toutes sélectionnées
        if (count($criteria['classFilter'])!=8) {
            $classes_meta_conditions = [];
            foreach ($criteria['classFilter'] as $class) {
                $classes_meta_conditions[] = [
                    'key'     => 'classes',
                    'value'   => '"' . $class . '"',  // important : chercher la valeur entre guillemets dans la serialization
                    'compare' => 'LIKE'
                ];
            }
            $meta_query[] = [
                'relation'     => 'OR',
                ...$classes_meta_conditions
            ];
        }
        
        // Définition du filtre sur les rituels, seulement si on filtre dessus.
        if ($criteria['onlyRituel']==1) {
            $meta_query[] = [
                'key'     => 'rituel',
                'value'   => '"r"',
                'compare' => 'LIKE'
            ];
        }
        
        // Définition du filtre sur les concentration, seulement si on filtre dessus.
        if ($criteria['onlyConcentration']==1) {
            $meta_query[] = [
                'key'     => 'concentration',
                'value'   => '"c"',
                'compare' => 'LIKE'
            ];
        }
        
        // Définition du $args pour la requête WP_Query
        $args = [
            'post_type'      => 'post',          // ou 'sort' si tu fais un CPT
            'posts_per_page' => -1,              // pagination
            'category_name'  => 'sort',         // le slug de ta catégorie
            'orderby'        => 'title',
            'order'          => 'ASC',
            'meta_query'     => $meta_query,
        ];
    
        $query = new \WP_Query($args);
        if ($query->have_posts()) :
            while ($query->have_posts()) {
                $query->the_post();
                $post = get_post();
                $rpgSpell = SpellFactory::fromWpPost($post);
                $collection->addItem($rpgSpell);
            }
            wp_reset_postdata();
        endif;

        return $collection;
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
                $rpgSpell = SpellFactory::fromWpPost($post);
                $collection->addItem($rpgSpell);
            }
            wp_reset_postdata();
        endif;



        return $collection;
    }

}
