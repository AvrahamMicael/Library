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

        $req = Container::getModel('request');
        $this->view->requests = $req->getRequests();

        $this->render('requests', 'layout3');
    }

    public function acceptRequest() {
        $this->validAuthAdmin();

        $req = Container::getModel('request');
        $req->__set('request_sender_id', $_POST['id_user']);
        $req->__set('requested_book_id', $_POST['id_book']);
        $req->acceptRequest();

        header('location: /view_requests');
    }

    public function bookInfo() {
        $this->validAuth();

        $book = Container::getModel('book');
        $book->__set('id', $_GET['id']);
        $this->view->book = $book->getBook();

        $user = Container::getModel('user');
        $user->__set('id_user', $_SESSION['id_user']);
        $this->view->alreadyHave = $user->getUserBooksId();

        $request = Container::getModel('request');
        $request->__set('requested_book_id', $_GET['id']);
        $request->__set('request_sender_id', $_SESSION['id_user']);
        $this->view->requested = $request->verifyRequest();
        $this->view->warning = $_GET['warning'] ?? '';

        $this->render('book_info', 'layout2');
    }

    public function currentlyUsing() {
        $this->validAuthAdmin();

        $user = Container::getModel('user');
        $this->view->books = $user->getBooks(true);

        $this->render('currently_using', 'layout3');
    }

    public function removeBook() {
        $this->validAuth();

        $id = $_GET['id'] ?? ''; //book_id

        $user = Container::getModel('user');
        $user->__set('id_user', $_SESSION['id_user']);
        $user->__set('id_book1', $id); //or 'id_book2'
        $user->removeUserBook();

        $req = Container::getModel('request');
        $req->__set('requested_book_id', $id);
        $req->toggleAvailable();

        header("location: /book_info?id=$id");
    }

    public function removeBookAdmin() {
        $this->validAuthAdmin();

        $id = $_GET['id'] ?? ''; //book_id
        $id_user = $_GET['id_user'] ?? '';

        $user = Container::getModel('user');
        $user->__set('id_user', $id_user);
        $user->__set('id_book1', $id); //or 'id_book2'
        $user->removeUserBook();

        $req = Container::getModel('request');
        $req->__set('requested_book_id', $id);
        $req->toggleAvailable();

        header('location: /currently_using');
    }

    public function request() {
        $this->validAuth();

        $id = $_GET['id'] ?? ''; //book_id

        $book = Container::getModel('book');
        $book->__set('id', $id);
        $available = $book->getBook()['available'];

        $location = "location: /book_info?id=$id";

        if($available == 1) { 

            $request = Container::getModel('request');
            $request->__set('requested_book_id', $id);
            $request->__set('request_sender_id', $_SESSION['id_user']);

            $user_reqs = $request->countUserRequests()['total'];

            $user = Container::getModel('user');
            $user->__set('id_user', $_SESSION['id_user']);

            $user_books_ids = $user->getUserBooksId();
            $user_books = 0;
            foreach($user_books_ids as $book_id) {
                if(!empty($book_id)) $user_books++;
            }

            if($user_reqs + $user_books < 2) {
                $request->sendRequest();
                header($location);
            } else header($location.'&warning=1');

        } else header($location);

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
        elseif($_SESSION['id_user'] == 1) header('location: /view_requests');
    }
    
    private function validAuthAdmin() {
        session_start();
        if($_SESSION['id_user'] != 1) header('location: /');
    }
}