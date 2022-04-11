<?php

namespace App\Models;

use App\Connection;
use MF\Model\Model;

final class User extends Model {
    private $id_user;
    private $name;
    private $email;
    private $password;

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
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function authenticate() {
        $query = '
            select id_user, name
            from tb_users
            where 
                email = :email
                and
                password = :password
        ';
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':email', $this->__get('email'));
        $stmt->bindValue(':password', $this->__get('password'));
        $stmt->execute();

        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        if(!empty($user)) {
            $this->__set('id_user', $user['id_user']);
            $this->__set('name', $user['name']);
        }
    }

    public function checkIfValid($name, $email, $password) {
        $name = $name ?? null;
        $email = $email ?? null;
        $password = $password ?? null;

        if(!is_null($name) && strlen($name) < 4) header('location: /?login=error'); //change location
        if(!is_null($email) && strlen($email) < 12) header('location: /?login=error');
        if(!is_null($password) && strlen($password) < 4) header('location: /?login=error');

        $this->__set('name', $name);
        $this->__set('email', $email);
        $this->__set('password', hash('sha3-512', $password));
    }

    public function signup() {
        $query = '
            insert into tb_users(name, email, password)
            values(:name, :email, :password)
        ';

        $stmt = $this->db->prepare($query);
        $stmt->bindValue('name', $this->__get('name'));
        $stmt->bindValue('email', $this->__get('email'));
        $stmt->bindValue('password', $this->__get('password'));
        $stmt->execute();
    }
}