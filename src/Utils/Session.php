<?php
namespace src\Utils;

use WP_User;

class Session
{
    public static function isPostSubmitted(): bool
    {
        return isset($_POST) && !empty($_POST);
    }

    public static function fromPost(string $field, $default = '', bool $sanitize=false): string
    {
        $strSanitized = isset($_POST[$field]) ? htmlentities((string) $_POST[$field], ENT_QUOTES, 'UTF-8') : $default;
        return $sanitize ? filter_var($strSanitized, FILTER_SANITIZE_URL) : $strSanitized;
    }

    public static function fromGet(string $field, $default = '', bool $sanitize=false): string
    {
        $strSanitized = isset($_GET[$field]) ? htmlentities((string) $_GET[$field], ENT_QUOTES, 'UTF-8') : $default;
        return $sanitize ? filter_var($strSanitized, FILTER_SANITIZE_URL) : $strSanitized;
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
