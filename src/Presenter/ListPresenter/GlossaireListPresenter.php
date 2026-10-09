<?php
namespace src\Presenter\ListPresenter;

use src\Collection\Collection;
use src\Presenter\ViewModel\GlossaireRow;

final class GlossaireListPresenter
{
    public function present(array $posts): Collection
    {
        $rows = [];

        foreach ($posts as $post) {
            $row = new GlossaireRow();

            $row->title = $post->post_title;
            $row->content = apply_filters(
                'the_content',
                $post->post_content
            );
            $row->url = '/glossary#'.$post->post_name;

            $rows[] = $row;
        }

        return new Collection($rows);
    }
}
