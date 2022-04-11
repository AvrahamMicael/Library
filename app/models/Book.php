<?php

namespace App\Models;

use App\Connection;
use MF\Model\Model;

final class Book extends Model {
    private int $id;
    private string $author;
    private string $title;
    private string $description;
    private string $published_at;
    private int $pages;
    private int $available;
    private string $genres;
    private string $image_link;

    public function __get($attr) {
        return $this->$attr;
    }
    public function __set($attr, $value) {
        $this->$attr = $value;
    }

    public function getData($onlyAvailable = false) {
        if($onlyAvailable == false) {
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
        $stmt = $this->db->query($query);
        $books = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        foreach($books as $key => $book) {
            $genresArray = explode('#', $book['genres']);
            $books[$key]['genres'] = implode(', ', $genresArray);
        }
        return $books;
    }

    public function getBookInfo() {
        $books = $this->getData();
        foreach($books as $book) {
            if($book['id'] == $this->__get('id')) $bk = $book;
        }

        try {
            return $bk;
        } catch(Error $e) {
            header('location: /available?error=404');
        }
    }
}