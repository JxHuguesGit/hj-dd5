<?php

namespace src\Presenter\ListPresenter;

use src\Constant\Routes as R;
use src\Collection\Collection;
use src\Presenter\ViewModel\GlossaireGroup;
use src\Presenter\ViewModel\GlossaireRow;

final class GlossaireListPresenter
{
    public function present(array $posts): Collection
    {
        $rows = [];

        foreach ($posts as $post) {
            $row = new GlossaireRow();

            $row->title = $this->getTitle($post);
            $row->content = apply_filters(
                'the_content',
                $post->post_content
            );
            $row->url = R::GLOSSARY_PREFIX . '#' . $post->post_name;
            $row->anchor = $post->post_name;

            $rows[] = $row;
        }

        $group = new GlossaireGroup();
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
                esc_url(home_url(R::RULES_PREFIX . R::GLOSSARY_PREFIX . '#' . $dependance->post_name)),
                esc_html($dependance->post_title)
            );
        }

        return $titleReturned;
    }
}
