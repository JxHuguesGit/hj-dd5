<?php

namespace src\Presenter\ListPresenter;

use src\Constant\Routes as R;
use src\Collection\Collection;

class RuleListPresenter
{
    public function rulePresent(
        $rowClass,
        $groupClass,
        string $baseUrl,
        array $posts
    ): Collection {
        $rows = [];
        foreach ($posts as $post) {
            $row = new $rowClass();
            $row->title = $this->getRuleTitle($post, $baseUrl);
            $row->content = apply_filters(
                'the_content',
                $post->post_content
            );
            $row->url = $baseUrl . '#' . $post->post_name;
            $row->anchor = $post->post_name;
            $this->addSpecifics($row, $post);
            $rows[] = $row;
        }
        $group = new $groupClass();
        $group->rows = $rows;
        return new Collection([$group]);
    }

    protected function addSpecifics(&$row, \WP_Post $post): void {}

    public function present(array $posts): Collection
    {
        return new Collection($posts);
    }

    protected function getRuleTitle(\WP_Post $post, string $baseUrl): string
    {
        $titleReturned = esc_html($post->post_title);
        $dependance = get_field('dependance', $post->ID);

        if ($dependance instanceof \WP_Post) {
            $titleReturned .= sprintf(
                ' [<a href="%s">%s</a>]',
                esc_url(home_url(R::RULES_PREFIX . $baseUrl . '#' . $dependance->post_name)),
                esc_html($dependance->post_title)
            );
        }

        return $titleReturned;
    }
}
