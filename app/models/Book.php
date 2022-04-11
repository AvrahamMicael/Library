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

    public function getAll() {
        $query = '
            select author, title, description, published_at, pages, available, image_link, genres
            from tb_books
        ';
        $stmt = $this->db->query($query);
        $books = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        foreach($books as $key => $book) {
            $genresArray = explode('#', $book['genres']);
            $books[$key]['genres'] = implode(' ,', $genresArray);
        }
        return $books;
    }
}