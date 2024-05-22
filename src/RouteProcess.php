<?php 

    namespace Rahat1470\PhpRouter;

use ReflectionMethod;

class RouteProcess{
    protected static function postRequest(callable|array $callback){
        if(is_array($callback)){
            $className = $callback[0];
            $method = $callback[1];
            $checkMethod = new ReflectionMethod($className,$method);
            if($checkMethod->isStatic()){
                $output = $className::$method((object)$_POST);
            }else{
                $class = new $className();
                $output = $class->$method((object)$_POST);
            }
        } else if(is_callable($callback)) {
            $output = call_user_func_array($callback, []);
        }
        return $output;
    }

    protected static function getRequest(callable|array $callback){
        if(is_array($callback)){
            $className = $callback[0];
            $method = $callback[1];
            $checkMethod = new ReflectionMethod($className,$method);
            if($checkMethod->isStatic()){
                $output = $className::$method();
            }else{
                $class = new $className();
                $output = $class->$method();
            }
        } else if(is_callable($callback)){
            $output = call_user_func_array($callback, []);
        }
        return $output;
    }

    protected static function postRequestWithParamiter(callable|array $callback, array $parameters)
    {
        if(is_array($callback)){
            $className = $callback[0];
            $method = $callback[1];
            $output = call_user_func_array([$className,$method],array_merge($parameters,[(object)$_POST]));
        } else if(is_callable($callback)){
            $output = call_user_func_array($callback, array_merge($parameters,[(object)$_POST]));
        }
        return $output;
    }

    protected static function getRequestWithParamiter(callable|array $callback, array $parameters)
    {
        if(is_array($callback)){
            $className = $callback[0];
            $method = $callback[1];
            $output = call_user_func_array([$className,$method],$parameters);
        } else if(is_callable($callback)){
            $output = call_user_func_array($callback, $parameters);
        }
        return $output;
    }

    public static function route($route, $callback)
    {
        if (!is_callable($callback) && !is_array($callback)) {
            if (!strpos($callback, '.php')) {
                $callback .= '.php';
            }
        }
        if ($route == "/404") {
            $output = self::getRequest($callback);
            if(is_array($output)){
                print_r($output);
            }else{
                echo $output;
            }
            return;
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
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $output = self::postRequest($callback);
            }else{
                // Get Request
                $output = self::getRequest($callback);
            }
            if(is_array($output)){
                print_r($output);
            }else{
                echo $output;
            }
            return;
            include_once __DIR__ . "/$callback";
            return;
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
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $output = self::postRequestWithParamiter($callback,$parameters);
        }else{
            $output = self::getRequestWithParamiter($callback,$parameters);
        }
        if(is_array($output)){
            print_r($output);
        }else{
            echo $output;
        }
        return;
        include_once __DIR__ . "/$callback";
        return;
    }
}