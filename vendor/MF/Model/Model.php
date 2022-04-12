<?php

namespace MF\Model;

abstract class Model {
    protected $db;

    public function __construct(\PDO $conn) {
        $this->db = $conn;
    }

    protected function prepareExecFetchQuery(string $query, array $arr, bool $fetchAll = false) {
        $stmt = $this->db->prepare($query);
        foreach($arr as $key => $value) {
            $stmt->bindValue($key + 1, $this->__get($value));
        }
        $stmt->execute();

        if($fetchAll == true) return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}