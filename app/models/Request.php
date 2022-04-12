<?php

namespace App\Models;

use App\Connection;
use MF\Model\Model;

final class Request extends Model {
    private $request_sender_id;
    private $requested_book_id;

    public function __get($attr) {
        return $this->$attr;
    }
    public function __set($attr, $value) {
        $this->$attr = $value;
    }

    public function sendRequest() {
        if(!$this->verifyRequest()) {
            $query = '
                insert into tb_requests(request_sender_id, requested_book_id)
                values(?, ?)
            ';
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(1, $this->__get('request_sender_id'));
            $stmt->bindValue(2, $this->__get('requested_book_id'));
            $stmt->execute();
            return true;
        } 
        return false;
    }

    public function removeRequest() {
        if($this->verifyRequest()) {
            $query = '
                delete from tb_requests
                where
                    request_sender_id = ?
                    and
                    requested_book_id = ?
            ';
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(1, $this->__get('request_sender_id'));
            $stmt->bindValue(2, $this->__get('requested_book_id'));
            $stmt->execute();
        }
    }
    
    private function verifyRequest() {
        $query = '
            select request_sender_id, requested_book_id
            from tb_requests
            where 
                request_sender_id = ?
                and
                requested_book_id = ?
        ';
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(1, $this->__get('request_sender_id'));
        $stmt->bindValue(2, $this->__get('requested_book_id'));
        $stmt->execute();

        return empty($stmt->fetch()) ? false : true;
    }
}