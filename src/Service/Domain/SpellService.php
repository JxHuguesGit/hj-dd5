<?php
namespace src\Service\Domain;

use src\Collection\Collection;
use src\Domain\Result\SpellResult;
use src\Factory\SpellFactory;

final class SpellService
{
    public function __construct(
        private WpPostService $wpService,
    ) {}

    public function allSpells(array $criteria = []): SpellResult
    {
        $collection = new Collection();

        $args = array_merge(
            [
                'post_type'      => 'post',
                'posts_per_page' => 10,
                'category_name'  => 'sort',
                'orderby'        => 'title',
                'order'          => 'ASC',
            ],
            $criteria
        );

        $query = $this->wpService->query($args);
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $post = $this->wpService->getPost();
                $rpgSpell = SpellFactory::fromWpPost($post);
                $collection->addItem($rpgSpell);
            }
            $this->wpService->resetPostdata();
        }

        return new SpellResult(
            collection: $collection,
            foundPosts: $query->found_posts,
            maxNumPages: $query->max_num_pages,
            currentPage: $args['paged'] ?? 1,
        );
    }
}
