<?php
namespace src\Service;

use WP_Post;

final class WpPostService
{
    public WP_Post $WpPost;
    public function getById(int $postId): ?WP_Post
    {
        $this->WpPost = get_post($postId) ?: null;
        return $this->WpPost;
    }

    public function getField(string $field)
    {
        return get_field($field, $this->WpPost->ID);
    }
}
