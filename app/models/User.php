<?php

namespace App\Models;

use App\Connection;
use MF\Model\Model;

final class User extends Model {
    private $id_user;
    private $name;
    private $email;
    private $password;
    private $id_book1;
    private $id_book2;

    public function __get($attr) {
        return $this->$attr;
    }
    public function __set($attr, $value) {
        $this->$attr = $value;
    }

    public function getData() {
        $query = '
            select id_user, name, email
            from tb_users
        ';
        return $this->prepareExecFetchQuery($query, [], true);
    }

    public function authenticate() {
        $query = '
            select id_user, name
            from tb_users
            where 
                email = ?
                and
                password = ?
        ';

        $user = $this->prepareExecFetchQuery($query, ['email', 'password']);

        if(!empty($user)) {
            $this->__set('id_user', $user['id_user']);
            $this->__set('name', $user['name']);
        }
    }

    public function getUserByEmail() {
        $query = '
            select *
            from tb_users
            where email = ?
        ';
        return $this->prepareExecFetchQuery($query, ['email']);
    }

    public function checkIfValid($name, $email, $password) {
        $name = $name ?? null;
        $email = $email ?? null;
        $password = $password ?? null;

        if(!is_null($name) && strlen($name) < 4) return true;
        if(!is_null($email) && strlen($email) < 12) return true;
        if(!is_null($password) && strlen($password) < 4) return true;

        $this->__set('name', ucfirst($name));
        $this->__set('email', $email);
        $this->__set('password', hash('sha3-512', $password));

        return false;
    }

    public function signup() {
        $query = '
            insert into tb_users(name, email, password)
            values(?, ?, ?)
        ';

        $this->prepareExecFetchQuery($query, ['name', 'email', 'password']);
    }

    public function getBooks(bool $currentlyUsing = false) {
        if(!$currentlyUsing) {
            $query = '
                select 
                    b.id,
                    b.author,
                    b.title,
                    b.description,
                    b.published_at,
                    b.pages,
                    b.available,
                    b.image_link,
                    b.genres,
                    u.id_book1,
                    u.id_book2
                from tb_books as b
                right join tb_users as u
                on
                    b.id = u.id_book1
                    or
                    b.id = u.id_book2
                where u.id_user = ?
            ';
            $books = $this->prepareExecFetchQuery($query, ['id_user'], true);
            foreach($books as $key => $book) {
                $genresArray = explode('#', $book['genres']);
                $books[$key]['genres'] = implode(', ', $genresArray);
            }

        } else {
            $query = '
                select 
                    b.id,
                    b.author,
                    b.title,
                    b.image_link,
                    u.name,
                    u.id_user
                from tb_books as b
                right join tb_users as u
                on
                    b.id = u.id_book1
                    or
                    b.id = u.id_book2
                where 
                    ISNULL(u.id_book1) = 0
                    or
                    ISNULL(u.id_book2) = 0
            ';
            $books = $this->prepareExecFetchQuery($query, [], true);
        }
        
        return $books;
    }

    public function getUserBooksId() {
        $books = $this->getBooks();
        $user_books_ids = [];
        $user_books_ids[] = $books[0]['id_book1'] ?? '';
        $user_books_ids[] = $books[0]['id_book2'] ?? '';
        return $user_books_ids;
    }

    public function removeUserBook() {
        $user_books_ids = $this->getUserBooksId();
        $id_book = '';
        if($user_books_ids[0] == $this->__get('id_book1')) $id_book = 'id_book1';
        if($user_books_ids[1] == $this->__get('id_book1')) $id_book = 'id_book2';

        $query = "
            update tb_users
            set $id_book = null
            where $id_book = ?
        ";
        $this->prepareExecFetchQuery($query, ['id_book1']);
    }
}