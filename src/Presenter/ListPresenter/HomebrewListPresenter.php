<?php

namespace src\Presenter\ListPresenter;

use src\Constant\Routes as R;
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
            $row->url = R::HOMEBREW_PREFIX . '#' . $post->post_name;
            $row->anchor = $post->post_name;
            $row->new = has_tag('new', $post);
            $row->refonte = has_tag('refonte', $post);

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
                esc_url(home_url(R::RULES_PREFIX . R::HOMEBREW_PREFIX . '#' . $dependance->post_name)),
                esc_html($dependance->post_title)
            );
        }

        return $titleReturned;
    }
}
