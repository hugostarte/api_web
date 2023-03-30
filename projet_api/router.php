<?php

spl_autoload_register(function($class){
    require(str_replace("\\","/",$class).".php");
});


$method = $_SERVER["REQUEST_METHOD"];


$routeJson = json_decode(file_get_contents("routing/route.json"));

foreach ($routeJson as $route) {

    $url = str_replace("/projet_api", "", $_SERVER['REQUEST_URI']);
    $result = preg_match_all("#\/([a-zA-Z]*)\/?([0-9]*)#", $url, $match);
    if ($result > 0 && $method == $route->method) {

        if (!empty($route->auth) && $route->auth) {
            try {
                getAuth();
            } catch (Exception $e) {
                echo json_encode("Token d'authentification incorrect");
                break;
            }
        }

        $param = array();
        if (!empty($route->param) && count($route->param) > 0) {
            foreach ($route->param as $key => $p) {
                $param[$p] = $match[$key + 1][0];
            }
        }
        $controllerName = "\\Controller\\" . ucfirst($route->controller) . "Controller";

        $controller = new $controllerName();
        $action = $route->action;
        call_user_func_array(array($controller, $action), $param);
        break;
    }
}


function getAuth()
{
    $token = str_replace("bearer ", "", $_SERVER['HTTP_AUTHORIZATION']);
    if (!empty($token)) {
        $decode = JWT\JWT::decode($token, new \JWT\Key("dz14a68df4s3f4e6z8f4ze681", 'HS256'));
        return $decode;
    }
    return null;
}
