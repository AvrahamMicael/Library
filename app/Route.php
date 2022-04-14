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
        $routes['view_requests'] = [
            'route' => '/view_requests',
            'controller' => 'AppController',
            'action' => 'viewRequests'
        ];
        $routes['accept_request'] = [
            'route' => '/accept_request',
            'controller' => 'AppController',
            'action' => 'acceptRequest'
        ];
        $routes['reject_request'] = [
            'route' => '/reject_request',
            'controller' => 'AppController',
            'action' => 'rejectRequest'
        ];
        $routes['remove_book'] = [
            'route' => '/remove_book',
            'controller' => 'AppController',
            'action' => 'removeBook'
        ];
        $routes['currently_using'] = [
            'route' => '/currently_using',
            'controller' => 'AppController',
            'action' => 'currentlyUsing'
        ];
        $routes['remove_user_book_admin'] = [
            'route' => '/remove_user_book_admin',
            'controller' => 'AppController',
            'action' => 'removeUserBookAdmin'
        ];
        $routes['add_book_view'] = [
            'route' => '/add_book_view',
            'controller' => 'AppController',
            'action' => 'addBookView'
        ];
        $routes['add_book'] = [
            'route' => '/add_book',
            'controller' => 'AppController',
            'action' => 'addBook'
        ];
        $routes['remove_book_permanently'] = [
            'route' => '/remove_book_permanently',
            'controller' => 'AppController',
            'action' => 'removeBookPermanently'
        ];
        $routes['remove_notification'] = [
            'route' => '/remove_notification',
            'controller' => 'AppController',
            'action' => 'removeNotification'
        ];
        $this->setRoutes($routes);
    }
}