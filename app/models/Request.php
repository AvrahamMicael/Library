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
            $this->prepareExecFetchQuery($query, ['request_sender_id', 'requested_book_id']);
            return true;
        } 
        return false;
    }

    public function removeRequest(bool $same_book = false) {
        $verify = $this->verifyRequest();
        if(!$same_book && ($verify || $verify == 'already have the book')) {
            $query = '
                delete from tb_requests
                where
                    request_sender_id = ?
                    and
                    requested_book_id = ?
            ';
            $this->prepareExecFetchQuery($query, ['request_sender_id', 'requested_book_id']);
        }
        if($same_book) {
            $query = '
                delete from tb_requests
                where requested_book_id = ?
            ';
            $this->prepareExecFetchQuery($query, ['requested_book_id']);
        }//no one can get the same book
    }
    
    public function verifyRequest() {
        //verify id_book1-2
        $query = '
            select id_book1, id_book2
            from tb_users
            where id_user = ?
        ';
        $user_books = $this->prepareExecFetchQuery($query, ['request_sender_id']);
        foreach($user_books as $key => $user_book) {
            if($user_book == $this->__get('requested_book_id')) {
                return 'already have the book';
            }
        }

        $query = '
            select request_sender_id, requested_book_id
            from tb_requests
            where 
                request_sender_id = ?
                and
                requested_book_id = ?
        ';
        $req = $this->prepareExecFetchQuery($query, ['request_sender_id', 'requested_book_id']);

        return empty($req) ? false : true;
    }

    public function getRequests() {
        $query = '
            select u.name, u.id_user, b.title, b.id
            from tb_books as b
            right join tb_requests as r
            on b.id = r.requested_book_id
            left join tb_users as u
            on r.request_sender_id = u.id_user
        ';
        return $this->prepareExecFetchQuery($query, [], true);
    }

    public function acceptRequest() {
        $query = '
            select id_book1, id_book2
            from tb_users
            where id_user = ?
        ';//before requesting, it's needed have less than 2 books
        $user_books = $this->prepareExecFetchQuery($query, ['request_sender_id']);
        foreach($user_books as $key => $user_book) {
            if(empty($user_book)) {
                global $which;
                $which = $key;
                break;
            }
        }
        $query = "
            update tb_users
            set $which = ?
            where id_user = ?
        ";
        $this->prepareExecFetchQuery($query, ['requested_book_id', 'request_sender_id']);
        $this->removeRequest(true);
        $this->toggleAvailable();
    }

    private function toggleAvailable() {
        $query = '
            select available
            from tb_books
            where id = ?
        ';
        $available = $this->prepareExecFetchQuery($query, ['requested_book_id']);
        $available = $available['available'] == 1 ? 0 : 1;
        $query = "
            update tb_books
            set available = $available
            where id = ?
        ";
        $this->prepareExecFetchQuery($query, ['requested_book_id']);
    }   

    public function countUserRequests() {
        $query = '
            select count(*) as total
            from tb_requests
            where request_sender_id = ?
        ';
        return $this->prepareExecFetchQuery($query, ['request_sender_id']);
    }
}