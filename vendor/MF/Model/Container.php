<?php

namespace MF\Model;

use App\Connection;

class Container {
    public static function getModel($type) {
        $conn = Connection::connect();
        $type = ucfirst($type);
        $class = "\\App\\Models\\$type";
        return new $class($conn);
    }
}