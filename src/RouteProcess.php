<?php 

    namespace Rahat1470\PhpRouter;

use ReflectionMethod;

class RouteProcess{
    public static function route($route, $path_to_include)
    {
        $callback = $path_to_include;
        if (!is_callable($callback) && !is_array($callback)) {
            if (!strpos($path_to_include, '.php')) {
                $path_to_include .= '.php';
            }
        }
        if ($route == "/404") {
            if (is_array($callback)) {
                $className = $callback[0];
                $method = $callback[1];
                $output = $className::$method();
                if(is_array($output)){
                    print_r($output);
                }else{
                    echo $output;
                }
                exit();
            }else if(is_callable($callback)){
                $output = call_user_func_array($callback, []);
                if(is_array($output)){
                    print_r($output);
                }else{
                    echo $output;
                }
                exit();
            }
            exit();
        }
        $request_url = filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_URL);
        $request_url = rtrim($request_url, '/');
        $request_url = strtok($request_url, '?');
        $route_parts = explode('/', $route);
        $request_url_parts = explode('/', $request_url);
        array_shift($route_parts);
        array_shift($request_url_parts);
        if ($route_parts[0] == '' && count($request_url_parts) == 0) {
            // Callback function
            if (is_array($callback)) {
                $className = $callback[0];
                $method = $callback[1];
                $checkMethod = new ReflectionMethod($className,$method);
                if($checkMethod->isStatic()){
                    $output = $className::$method();
                }else{
                    $class = new $className();
                    $output = $class->$method();
                }
                
                if(is_array($output)){
                    print_r($output);
                }else{
                    echo $output;
                }
                exit();
            }else if(is_callable($callback)){
                $output = call_user_func_array($callback, []);
                if(is_array($output)){
                    print_r($output);
                }else{
                    echo $output;
                }
                exit();
            }
            include_once __DIR__ . "/$path_to_include";
            exit();
        }
        if (count($route_parts) != count($request_url_parts)) {
            return;
        }
        $parameters = [];
        for ($__i__ = 0; $__i__ < count($route_parts); $__i__++) {
            $route_part = $route_parts[$__i__];
            if (preg_match("/^[$]/", $route_part)) {
                $route_part = ltrim($route_part, '$');
                array_push($parameters, $request_url_parts[$__i__]);
                $$route_part = $request_url_parts[$__i__];
            } else if ($route_parts[$__i__] != $request_url_parts[$__i__]) {
                return;
            }
        }
        // Callback function
        if (is_array($callback)) {
            print_r($callback);
            $className = $callback[0];
            $method = $callback[1];
            $output = call_user_func_array([$className,$method],$parameters);
            if(is_array($output)){
                print_r($output);
            }else{
                echo $output;
            }
            exit();
        }else if(is_callable($callback)){
            $output = call_user_func_array($callback, $parameters);
            if(is_array($output)){
                print_r($output);
            }else{
                echo $output;
            }
            exit();
        }
        include_once __DIR__ . "/$path_to_include";
        exit();
    }
}