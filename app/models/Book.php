<?php

namespace App\Models;

use App\Connection;
use MF\Model\Model;

class Book extends Model {
    public function getData() {
        $query = '
            select author, title, description, published_at, pages, available, image, genres
            from tb_books
        ';
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}