<?php
namespace src\Utils;

use WP_User;

class Session
{
    /** -------------------- POST -------------------- */
    public static function isPostSubmitted(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }
    
    public static function getPost(): array
    {
        $result = [];
        foreach ($_POST as $key => $value) {
            $result[$key] = static::fromPost($key);
        }
        return $result;
    }

    public static function fromPost(string $field, mixed $default = '', ?string $sanitize = null): mixed
    {
        return self::extractValue($_POST[$field] ?? $default, $sanitize);
    }
    
    public static function fromGet(string $field, mixed $default = '', ?string $sanitize = null): mixed
    {
        return self::extractValue($_GET[$field] ?? $default, $sanitize);
    }

    public static function fromServer(string $field, ?string $sanitize = null): mixed
    {
        return self::extractValue($_SERVER[$field] ?? '', $sanitize);
    }
    
    /** -------------------- Sanitize centralisé -------------------- */
    private static function extractValue(mixed $value, ?string $sanitize): mixed
    {
        if (is_array($value)) {
            return array_map(fn($v) => self::extractValue($v, $sanitize), $value);
        }

        return self::sanitizeValue($value, $sanitize);
    }

    private static function sanitizeValue(string $value, ?string $sanitize): mixed
    {
        return match ($sanitize) {
            null       => $value, // raw
            'escape'   => esc_html($value),
            'url'      => filter_var($value, FILTER_SANITIZE_URL),
            'email'    => filter_var($value, FILTER_SANITIZE_EMAIL),
            'int'      => intval($value),
            'string'   => sanitize_text_field($value),
            default    => $value
        };
    }
    
    /** -------------------- SESSION -------------------- */
    public static function setSession(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    public static function fromSession(string $key, mixed $default = ''): mixed
    {
        return $_SESSION[$key] ?? $default;
    }

    public static function unsetSession(string $key): void
    {
        unset($_SESSION[$key]);
    }
    
     /** -------------------- WordPress User -------------------- */
    public static function getWpUser(): WP_User
    {
        if (is_user_logged_in()) {
            return wp_get_current_user();
        }

        // Guest user
        $user = new WP_User();
        $user->ID = 0;
        $user->user_login = 'guest';
        $user->user_nicename = 'guest';
        $user->display_name = 'Guest';
        return $user;
    }
}