<?php

namespace App\Models;

use App\Connection;
use MF\Model\Model;

final class Notification extends Model {
    private $id_user;
    private $notification;

    public function __get($attr) {
        return $this->$attr;
    }
    public function __set($attr, $value) {
        $this->$attr = $value;
    }

    public function sendNotification() {
        $query = '
            insert into tb_notifications(id_user, notification)
            values(?, ?)
        ';
        $this->prepareExecFetchQuery($query, ['id_user', 'notification']);
    }

    public function getUserNotifications() {
        $query = '
            select notification, id_not
            from tb_notifications
            where id_user = ?
            order by id_not desc
        ';
        return $this->prepareExecFetchQuery($query, ['id_user'], true);
    }

    public function removeNotification() {
        $query = '
            delete from tb_notifications
            where
                id_user = ?
                and
                id_not = ?
        ';
        $this->prepareExecFetchQuery($query, ['id_user', 'id_not']);
    }
}