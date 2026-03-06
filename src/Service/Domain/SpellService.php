<?php
namespace src\Service\Domain;

use src\Collection\Collection;
use src\Constant\Constant as C;
use src\Domain\Entity\Spell;
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
                'orderby'        => C::TITLE,
                'order'          => C::ASC,
            ],
            $criteria
        );

        $query = $this->wpService->query($args);
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $post     = $this->wpService->getPost();
                $rpgSpell = SpellFactory::fromWpPost($post);
                $collection->add($rpgSpell);
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

    public function spellBySlug(string $slug): Spell
    {
        $spellResult = $this->allSpells([C::NAME => $slug]);
        return ($spellResult->collection)->first();
    }

    public function getPreviousAndNext(Spell $spell): array
    {
        $allSpells = $this->allSpells(['posts_per_page' => -1]);
        $idx       = $allSpells->collection->findKey(fn($post) => $post->slug === $spell->slug);

        $idxPrev = $idx == 0 ? $allSpells->collection->count() : $idx - 1;
        $idxNext = $idx == $allSpells->collection->count() ? 0 : $idx + 1;

        $prev = $allSpells->collection->slice($idxPrev, 1)->first();
        $next = $allSpells->collection->slice($idxNext, 1)->first();
        return [C::PREV => $prev, C::NEXT => $next];
    }
}
