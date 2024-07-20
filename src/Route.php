<?php

namespace App;

class Route
{
    private static function getURI():array
    {
        return explode("/", $_GET["route"]); //return empty
    }

    private static function processURI():array
    {
        //can be empty or /
        $controllerPart = self::getURI()[0] ?? '';
        $methodPart = self::getURI()[1] ?? '';
        $numPart = count(self::getURI());
        $argsPart = [];
        for ($i =2; $i < $numPart; $i++){
            $argsPart[] = self::getURI()[$i] ?? '';
        }

        //defaults
        $controller = !empty($controllerPart) ? ucfirst($controllerPart).'Controller'
            : 'HomeController';
        $method = !empty($methodPart) ? $methodPart : 'index';
        $args = !empty($argsPart) ? $argsPart : [];

        return [
          'controller' => $controller,
          'method' => $method,
          'args' => $args
        ];
    }

    public static function contentToRender():void
    {
        //__DIR__ or DOCROOT SOLVE REQUIRE ERROR
        $vals = scandir(DOCROOT.'/src/Controllers');

        $uri = self::processURI();
        //var_dump($uri);

        //Check if uri require a disponible Controller
        if ( ! in_array($uri['controller'].'.php', $vals) ){
            require_once DOCROOT .'/templates/404.php';
        }

        //Check if User is authenticate when route is called
        if ( !Auth::isLoggedIn() && $uri['controller'] == 'DashboardController' || $uri['controller'] == 'AdminController')
        {
            $title = 'Error 403';
            $content = Auth::AuthorizationRequired();
            require_once DOCROOT .'/templates/layout.php';
        }

        $controller = 'App\Controllers\\'.$uri["controller"];
        $method = $uri['method'];
        $args = $uri['args'];

        if ( ! method_exists($controller, $method) ){

            $method = 'index';
            $args ? ( new $controller())->{$method}(...$args) :
                ( new $controller())->{$method}()
            ;
        }

        $args ? ( new $controller())->{$method}(...$args) :
            ( new $controller())->{$method}()
        ;
    }

}