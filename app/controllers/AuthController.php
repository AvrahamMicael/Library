<?php

namespace App\Controllers;

use App\Connection;
//MF
use MF\Controller\Action;
use MF\Model\Container;

final class AuthController extends Action {
    public function authenticate() {
        $user = Container::getModel('user');

        $user->checkIfValid(null, $_POST['email'], $_POST['password']);

        print_r($user->authenticate());

        if(!empty($user->__get('id_user')) && !empty($user->__get('name'))) {
            session_start();
            $_SESSION['id_user'] = $user->__get('id_user');
            $_SESSION['name'] = $user->__get('name');

            header('location: /available');

        } else header('location: /?login=error');

    }

    public function signup() {
        $user = Container::getModel('user');

        $user->checkIfValid($_POST['name'], $_POST['email'], $_POST['password']);

        if(count($user->authenticate()) != 0 ) header('location: /signup?signup=error');

        $user->signup();

        header('location: /?signup=success');
    }

    public function logoff() {
        session_start();
        session_destroy();
        header('location: /');
    }
}