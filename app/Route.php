<?php

namespace App;

use MF\Init\Bootstrap;

class Route extends Bootstrap {
    //initRoutes
    protected function initRoutes() {
        $routes['home'] = [
            'route' => '/',
            'controller' => 'indexController',
            'action' => 'index'
        ];
        $routes['signup'] = [
            'route' => '/signup',
            'controller' => 'indexController',
            'action' => 'signup'
        ];
        $routes['auth'] = [
            'route' => '/auth',
            'controller' => 'AuthController',
            'action' => 'authenticate'
        ];
        $routes['auth_signup'] = [
            'route' => '/auth_signup',
            'controller' => 'AuthController',
            'action' => 'signup'
        ];
        $this->setRoutes($routes);
    }
}