<?php

namespace App\Models;

use App\Connection;
use MF\Model\Model;

final class Book extends Model {
    private $id;
    private $author;
    private $title;
    private $description;
    private $published_at;
    private $pages;
    private $available;
    private $genres;
    private $image_link;

    public function __get($attr) {
        return $this->$attr;
    }
    public function __set($attr, $value) {
        $this->$attr = $value;
    }

    public function getData($onlyAvailable = false) {
        if(!$onlyAvailable) {
            $query = '
                select id, author, title, description, published_at, pages, available, image_link, genres
                from tb_books
            ';
        } else {
            $query = '
                select id, author, title, description, published_at, pages, available, image_link, genres
                from tb_books
                where available = 1
            ';
        }
        $books = $this->prepareExecFetchQuery($query, [], true);
        foreach($books as $key => $book) {
            $genresArray = explode('#', $book['genres']);
            $books[$key]['genres'] = implode(', ', $genresArray);
        }
        return $books;
    }

    public function getBook() {
        $books = $this->getData();
        $bk = null;
        foreach($books as $book) {
            if($book['id'] == $this->__get('id')) $bk = $book;
        }

        if(is_null($bk)) header('location: /available?error=404');
        return $bk;
    }

    public function addBook() {
        $query = '
            insert into tb_books(title, author, description, published_at, pages, genres, image_link)
            values(?, ?, ?, ?, ?, ?, ?)
        ';
        $this->prepareExecFetchQuery($query, ['title', 'author', 'description', 'published_at', 'pages', 'genres', 'image_link']);
    }

}