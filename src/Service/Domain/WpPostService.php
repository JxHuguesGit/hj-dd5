<?php
namespace src\Service\Domain;

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

    public function getByTitle(
        string $title,
        ?string $category = null
    ): ?WP_Post {
        $args = [
            'post_type'      => 'post',
            'post_status'    => 'publish',
            'posts_per_page' => 1,
            'title'          => $title,
        ];

        if ($category !== null) {
            $args['category_name'] = $category;
        }

        $query = $this->query($args);

        return $query->posts[0] ?? null;
    }
}
