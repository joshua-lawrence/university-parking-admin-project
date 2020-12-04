<?php
class Database {
    private $_db;
    static $_instance;

    private function __construct() {
        $this->_db = new PDO('mysql:host=127.0.0.1:3306;dbname=group10project',
        'root',
        '');
        $this->_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    private function __clone(){}

    public static function getInstance() {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function query($sql) {
        return $this->_db->query($sql);
    }

    public function execute($sql, $data) {
        $stmt = $this->_db->prepare($sql);
        $stmt->execute($data);
        return $this->_db->lastInsertId();
    }
}