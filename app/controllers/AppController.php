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

    public function viewRequests() {
        $this->validAuthAdmin();

        $this->render('requests', 'layout3');
    }

    public function bookInfo() {
        $this->validAuth();

        $book = Container::getModel('book');
        $book->__set('id', $_GET['id']);
        $this->view->book = $book->getBook();

        $request = Container::getModel('request');
        $request->__set('requested_book_id', $_GET['id']);
        $request->__set('request_sender_id', $_SESSION['id_user']);

        $this->view->requested = $request->verifyRequest();

        $this->render('book_info', 'layout2');
    }

    public function request() {
        $this->validAuth();

        $id = $_GET['id'] ?? ''; //book_id

        $book = Container::getModel('book');
        $book->__set('id', $id);
        $available = $book->getBook()['available'];

        if($available == 1) { 

            $request = Container::getModel('request');
            $request->__set('requested_book_id', $id);
            $request->__set('request_sender_id', $_SESSION['id_user']);
            $request->sendRequest();

        }

        header("location: /book_info?id=$id");
    }

    public function removeRequest() {
        $this->validAuth();

        $id = $_GET['id'] ?? ''; //book_id

        $request = Container::getModel('request');
        $request->__set('requested_book_id', $id);
        $request->__set('request_sender_id', $_SESSION['id_user']);
        $request->removeRequest();

        header("location: /book_info?id=$id");
    }

    private function validAuth() {
        session_start();
        if(empty($_SESSION['id_user']) && empty($_SESSION['name'])) header('location: /');
        if($_SESSION['id_user'] == 1) header('location: /view_requests');
    }
    
    private function validAuthAdmin() {
        session_start();
        if($_SESSION['id_user'] != 1) header('location: /');
    }
}