<?php
namespace src\Service;

use WP_Post;
use WP_Query;

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

    public function getPostContent(): string
    {
        return $this->wpPost->post_content ?? '';
    }

    public function query(array $args): ?WP_Query
    {
        return new WP_Query($args);
    }

    public function getPost(): ?WP_Post
    {
        return get_post();
    }

    public function resetPostdata(): void
    {
        wp_reset_postdata();
    }
}
