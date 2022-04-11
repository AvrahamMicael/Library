<?php

namespace App\Models;

use App\Connection;
use MF\Model\Model;

class User extends Model {
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
        $stmt->bindValue('email', $this->__get('email'));
        $stmt->bindValue('password', $this->__get('password'));
        $stmt->execute();

        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        if(!is_null($user)) {
            $this->__set('id_user', $user->__get('id_user'));
            $this->__set('name', $user->__get('name'));
        }

        return $user;
    }

    public function checkIfValid($name, $email, $pass) {
        $name = $_POST['name'] ?? null;
        $email = $_POST['email'] ?? null;
        $password = $_POST['password'] ?? null;

        if(strlen($name) < 4 || strlen($email) < 12 || strlen($pass) < 4) header('location: /?login=error') 

        $user->__set('name', $name);
        $user->__set('email', $email);
        $user->__set('password', hash('sha3-512', $pass));
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