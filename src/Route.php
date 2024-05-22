<?php
    namespace Rahat1470\PhpRouter;

use Exception;
use UnexpectedValueException;

class Route extends RouteProcess{
    private static $access = true;
    public function __construct(string $value = null, bool $replace = true, int $response_code = 0)
    {
        if($value != null){
            header($value,$replace,$response_code);
        }
        
    }

    public static function setHeader(string $header, bool $replace = true, int $response_code = 0){
        new self($header,$replace,$response_code);
    }



    public static function check($val,$callback = null){
        self::$access = $val;
        $callback();
    }
    public static function get($route, $path_to_include)
    {
        if($route === $_SERVER['PATH_INFO']){
            if(self::$access){
                try{
                    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                        self::route($route, $path_to_include);
                        exit();
                    }else{
                        throw new Exception("{$_SERVER['REQUEST_METHOD']} Method not allowed");
                    }
                }catch(UnexpectedValueException $e){
                    echo json_encode("Error: " . $e->getMessage());
                }catch(Exception $e){
                    echo json_encode('Method Error: ' . $e->getMessage());
                }
            }else{
                echo json_encode([
                    'status'    => 401,
                    'message'   => 'Unauthenticated'
                ]);
                exit();
            }
        }
    }

    public static function post($route, $path_to_include)
    {
        if($route === $_SERVER['PATH_INFO']){
            if(self::$access){
                try{
                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        self::route($route, $path_to_include);
                        exit();
                    }else{
                        throw new Exception("{$_SERVER['REQUEST_METHOD']} Method not allowed.");
                    }
                }catch(Exception $e){
                    echo json_encode('Method Error: ' . $e->getMessage());
                }
            }else{
                echo json_encode([
                    'status'    => 401,
                    'message'   => 'Unauthenticated'
                ]);
                exit();
            }
            
        }
        
    }

    public static function put($route, $path_to_include)
    {
        if($route === $_SERVER['PATH_INFO']){
            if(self::$access){
                try{
                    if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
                        self::route($route, $path_to_include);
                        exit();
                    }else{
                        throw new Exception("{$_SERVER['REQUEST_METHOD']} Method not allowed.");
                    }
                }catch(UnexpectedValueException $e){
                    echo json_encode("Error: " . $e->getMessage());
                }catch(Exception $e){
                    echo json_encode('Method Error: ' . $e->getMessage());
                }
            }else{
                echo json_encode([
                    'status'    => 401,
                    'message'   => 'Unauthenticated'
                ]);
                exit();
            }
        }
    }

    public static function patch($route, $path_to_include)
    {
        if($route === $_SERVER['PATH_INFO']){
            if(self::$access){
                try{
                    if ($_SERVER['REQUEST_METHOD'] == 'PATCH') {
                        self::route($route, $path_to_include);
                        exit();
                    }else{
                        throw new Exception("{$_SERVER['REQUEST_METHOD']} Method not allowed.");
                    }
                }catch(UnexpectedValueException $e){
                    echo json_encode("Error: " . $e->getMessage());
                }catch(Exception $e){
                    echo json_encode('Method Error: ' . $e->getMessage());
                }
            }else{
                echo json_encode([
                    'status'    => 401,
                    'message'   => 'Unauthenticated'
                ]);
                
                exit();
            }
        }
    }

    public static function delete($route, $path_to_include)
    {
        if($route === $_SERVER['PATH_INFO']){
            if(self::$access){
                try{
                    if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
                        self::route($route, $path_to_include);
                        exit();
                    }else{
                        throw new Exception("{$_SERVER['REQUEST_METHOD']} Method not allowed.");
                    }
                }catch(UnexpectedValueException $e){
                    echo json_encode("Error: " . $e->getMessage());
                }catch(Exception $e){
                    echo json_encode('Method Error: ' . $e->getMessage());
                }
            }else{
                echo json_encode([
                    'status'    => 401,
                    'message'   => 'Unauthenticated'
                ]);
                exit();
            }
        }
    }
    
    public static function any($route, $path_to_include)
    {
        self::route($route, $path_to_include);
    }

    public static function notFound($callback){
        self::route('/404',$callback);
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