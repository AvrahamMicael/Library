<?php

namespace App\Controllers;

use App\Connection;
//MF
use MF\Controller\Action;
use MF\Model\Container;

final class AuthController extends Action {
    public function authenticate() {
        $user = Container::getModel('user');

        $error = $user->checkIfValid(null, $_POST['email'], $_POST['password']);

        $user->authenticate();

        if(!empty($user->__get('id_user')) && !empty($user->__get('name'))) {
            session_start();
            $_SESSION['id_user'] = $user->__get('id_user');
            $_SESSION['name'] = $user->__get('name');

            if($_SESSION['id_user'] == 1) header('location: /view_requests');

            header('location: /available');

        } elseif($error == true) header('location: /?error=2');
        else header('location: /?error=1');

    }

    public function signup() {
        $user = Container::getModel('user');

        $user->checkIfValid($_POST['name'], $_POST['email'], $_POST['password']);


        if(!empty($user->getUserByEmail())) header('location: /signup?error=3');
        else {
            $user->signup();
            if(!$error) header('location: /?signup=success');
            else header('location: /signup?error=2');
        }
    }

    public function logoff() {
        session_start();
        session_destroy();
        header('location: /');
    }
}