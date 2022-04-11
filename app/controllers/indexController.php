<?php

namespace App\Controllers;


use App\Connection;
//MF
use MF\Controller\Action;
use MF\Model\Container;

//models
use App\Models\Book;
use App\Models\User;

final class IndexController extends Action {
    public function index() {
        $this->render('index');
    }

    public function signup() {
        $this->render('signup');
    }
}