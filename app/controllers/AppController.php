<?php

namespace App\Controllers;

use App\Connection;
//MF
use MF\Controller\Action;
use MF\Model\Container;

//models
use App\Models\Book;
use App\Models\User;

final class AppController extends Action {
    public function available() {
        $this->validAuth();

        $book = Container::getModel('book');
        $this->view->books = $book->getData(true);

        $this->view->content = 'available';
        $this->render('books', 'layout2');
    }
    
    public function yourBooks() { 
        $this->validAuth();
        
        $user = Container::getModel('user');
        $user->__set('id_user', $_SESSION['id_user']);
        $this->view->books = $user->getBooks();

        $this->view->content = 'your_books';
        $this->render('books', 'layout2');
    }
    
    public function all() {
        $this->validAuth();
        
        $book = Container::getModel('book');
        $this->view->books = $book->getData();
        
        $this->view->content = 'all';
        $this->render('books', 'layout2');
    }

    public function bookInfo() {
        $this->validAuth();

        $book = Container::getModel('book');
        $book->__set('id', $_GET['id']);
        $this->view->book = $book->getBookInfo();

        $this->render('book_info', 'layout2');
    }

    private function validAuth() {
        session_start();
        if(empty($_SESSION['id_user']) && empty($_SESSION['name'])) header('location: /');
    }
}