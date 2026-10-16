<?php
namespace src\Presenter\ListPresenter;

use src\Collection\Collection;
use src\Presenter\ViewModel\HomebrewGroup;
use src\Presenter\ViewModel\HomebrewRow;

final class HomebrewListPresenter
{
    public function present(array $posts): Collection
    {
        $rows = [];

        foreach ($posts as $post) {
            $row = new HomebrewRow();

            $row->title = $this->getTitle($post);
            $row->content = apply_filters(
                'the_content',
                $post->post_content
            );
            $row->url = '/homebrew-'.$post->post_name;

            $rows[] = $row;
        }

        $group = new HomebrewGroup();
        $group->rows = $rows;
        return new Collection([$group]);
    }

    private function getTitle(\WP_Post $post): string
    {
        $titleReturned = esc_html($post->post_title);
        $dependance = get_field('dependance', $post->ID);

        if ($dependance instanceof \WP_Post) {
            $titleReturned .= sprintf(
                ' [<a href="%s">%s</a>]',
                esc_url(home_url('/rules/homebrew-' . $dependance->post_name)),
                esc_html($dependance->post_title)
            );
        }

        return $titleReturned;
    }
}
