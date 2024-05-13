<?php
    namespace Rahat1470\PhpRouter;

class Route extends RouteProcess{
    public static function get($route, $path_to_include)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            self::route($route, $path_to_include);
        }
    }

    public static function post($route, $path_to_include)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            self::route($route, $path_to_include);
        }
    }

    public static function put($route, $path_to_include)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
            self::route($route, $path_to_include);
        }
    }

    public static function patch($route, $path_to_include)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'PATCH') {
            self::route($route, $path_to_include);
        }
    }

    public static function delete($route, $path_to_include)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
            self::route($route, $path_to_include);
        }
    }
    
    public static function any($route, $path_to_include)
    {
        self::route($route, $path_to_include);
    }
    
    public static function out($text)
    {
        echo htmlspecialchars($text);
    }

    public static function set_csrf()
    {
        session_start();
        if (!isset($_SESSION["csrf"])) {
            $_SESSION["csrf"] = bin2hex(random_bytes(50));
        }
        echo '<input type="hidden" name="csrf" value="' . $_SESSION["csrf"] . '">';
    }

    public static function is_csrf_valid()
    {
        session_start();
        if (!isset($_SESSION['csrf']) || !isset($_POST['csrf'])) {
            return false;
        }
        if ($_SESSION['csrf'] != $_POST['csrf']) {
            return false;
        }
        return true;
    }
}