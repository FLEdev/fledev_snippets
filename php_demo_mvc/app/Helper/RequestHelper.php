<?php

namespace Helper;

use Symfony\Component\Yaml\Yaml;

final class RequestHelper
{
    const ROUTES_PATH =  BASE_PATH_DIR . '/app/config/routes.yml';
    private $failureController;
    private $failureAction;
    private $failureCode;

    public function __construct()
    {
        $this->failureController = 'Controller\ErrorController';
        $this->failureAction = 'errorPageAction';
        $this->failureCode = '403';
    }

    public function getRequest() :string
    {
        return isset($_REQUEST['req']) ? rawurldecode($_REQUEST['req']) : '/';
    }

    public function processRequest() :void
    {
        $request = $this->getRequest();
        $routes = $this->getRoutes();
        $matchRoute = false;
        foreach($routes as $route) {
            $matchArr = $this->matchRequest($route, $request);
            if(!empty($matchArr)) {
                $matchRoute = true;
                echo $this->callAction($route['controller'], $route['action'], array_slice($matchArr, 1));
                break;
            }
        }
        // no Route match
        if(!$matchRoute) {
            echo $this->callAction($this->failureController, $this->failureAction, [$this->failureCode]);
        }
    }

    private function matchRequest($route, $request) :array
    {
        $returnMatch = [];
        $slashCheck = $request == '/' || $route['url'] == '/';
        if($slashCheck) {
            $returnMatch = ($request === $route['url']) ? [$route['url']] : [];
        } else {
            $regexpRequest = $this->routePathRegexp(ltrim($route['url'], '/'));
            $pattern = '/' . $regexpRequest . '/';
            preg_match($pattern, $request, $returnMatch);
        }
        return $returnMatch;
    }

    private function getRoutes() :array
    {
        $definedRoutes = [];
        if(file_exists(self::ROUTES_PATH)) {
            $definedRoutes = Yaml::parse(file_get_contents(self::ROUTES_PATH));
        }
        return current($definedRoutes);
    }

    private function routePathRegexp($route) :string
    {
        return preg_replace(['/\//', '/{d}/', '/{w}/'], ['\/', '(\d+)', '(\w+)'], $route);
    }

    final private function callAction($controller, $action, $parameters)
    {
        $className = $controller;
        $tmpController = new $className();
        return $tmpController->{$action}($parameters);
    }

}