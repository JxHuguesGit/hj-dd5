<?php
namespace src\Service;

use WP_Post;

final class WpPostService
{
    public ?WP_Post $wpPost;

    public function getById(int $postId): ?WP_Post
    {
        $this->wpPost = get_post($postId) ?: null;
        return $this->wpPost;
    }

    public function getField(string $field)
    {
        return get_field($field, $this->wpPost->ID);
    }
}
