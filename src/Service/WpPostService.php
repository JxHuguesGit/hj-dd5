<?php
namespace src\Service;

use WP_Post;

final class WpPostService
{
    public function getById(int $postId): ?WP_Post
    {
        return get_post($postId) ?: null;
    }
}
