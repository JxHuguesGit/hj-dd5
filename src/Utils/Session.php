<?php
namespace src\Utils;

use WP_User;

class Session
{
    public static function isPostSubmitted(): bool
    {
        return isset($_POST) && !empty($_POST);
    }
    
    public static function getPost(): array
    {
        $result = [];
        foreach ($_POST as $key => $value) {
            $result[$key] = static::fromPost($key);
        }
        return $result;
    }

    public static function fromPost(string $field, array|string $default = '', bool $sanitize=false): array|string
    {
        if (!isset($_POST[$field])) {
            return $default;
        }

	    $data = $_POST[$field];
        
        if (is_array($data)) {
            return array_map(fn($item) =>
                self::sanitizeValue($item, $sanitize),
                $data
            );
        }

	    $data = htmlentities((string) $data, ENT_QUOTES, 'UTF-8');
	    return self::sanitizeValue($data, $sanitize);
    }

    public static function fromGet(string $field, array|string $default = '', bool $sanitize=false): array|string
    {
        if (!isset($_GET[$field])) {
            return $default;
        }

	    $data = $_GET[$field];
        
        if (is_array($data)) {
            return array_map(fn($item) =>
                self::sanitizeValue($item, $sanitize),
                $data
            );
        }

	    $data = htmlentities((string) $data, ENT_QUOTES, 'UTF-8');
	    return self::sanitizeValue($data, $sanitize);
    }
    
    private static function sanitizeValue(mixed $value, bool $sanitize): string
    {
        if ($sanitize) {
            $value = filter_var($value, FILTER_SANITIZE_URL);
        }
        return $value;
    }

    public static function fromServer(string $field): string
    {
        $strSanitized = isset($_SERVER[$field]) ? htmlentities((string) $_SERVER[$field], ENT_QUOTES, 'UTF-8') : '';
        return filter_var($strSanitized, FILTER_SANITIZE_URL);
    }

    public static function getWpUser(): WP_User
    {
        if (is_user_logged_in()) {
            $currentUser = wp_get_current_user();
        } else {
            $currentUser = new WP_User();
            $currentUser->data->ID = '0';
            $currentUser->data->user_login = 'guest';
            $currentUser->data->user_nicename = 'guest';
            $currentUser->data->user_display_name = 'Guest';
        }
        return $currentUser;
    }

    public static function setSession(string $key, $value): void
    {
        $_SESSION[$key] = $value;
    }
    
    public static function fromSession(string $key): mixed
    {
        return $_SESSION[$key] ?? '';
    }

    public static function unsetSession(string $key): void
    {
        unset($_SESSION[$key]);
    }

}
