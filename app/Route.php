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
        $routes['logoff'] = [
            'route' => '/logoff',
            'controller' => 'AuthController',
            'action' => 'logoff'
        ];
        $routes['available'] = [
            'route' => '/available',
            'controller' => 'AppController',
            'action' => 'available'
        ];
        $routes['your_books'] = [
            'route' => '/your_books',
            'controller' => 'AppController',
            'action' => 'yourBooks'
        ];
        $routes['all'] = [
            'route' => '/all',
            'controller' => 'AppController',
            'action' => 'all'
        ];
        $routes['book_info'] = [
            'route' => '/book_info',
            'controller' => 'AppController',
            'action' => 'bookInfo'
        ];
        $routes['request'] = [
            'route' => '/request',
            'controller' => 'AppController',
            'action' => 'request'
        ];
        $routes['remove_request'] = [
            'route' => '/remove_request',
            'controller' => 'AppController',
            'action' => 'removeRequest'
        ];
        $this->setRoutes($routes);
    }
}