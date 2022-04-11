<?php

namespace App;

class Connection {
    public static function connect() {
        try {

            $conn = new \PDO(
                'mysql:host=localhost;dbname=library;charset=utf8',
                'root',
                ''
            );

            return $conn;

        } catch(PDOException $e) {
            // treatment
        }
    }
}