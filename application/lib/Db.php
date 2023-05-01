<?php
namespace application\lib;

use PDO;

class Db
{
    protected $db;
    public function __construct()
    {
        $config = require 'application/config/db.php';
        $dsn    = ('mysql:host=' . $config['host'] . ';dbname=' . $config['dbname'] . '');
        try {
            $this->db = new PDO($dsn, $config['user'], $config['password']);
            $this->db->exec("set names utf8");
        } catch (PDOException $e) {
            $error_message = $e->getMessage();
            echo "<p>An error occured while connecting to the database: $error_message </p>";
        }
    }
    public function query($sql, $params = [])
    {
        $stmt = $this->db->prepare($sql);
        if (!empty($params)) {
            foreach ($params as $key => $val) {
                $stmt->bindValue(':' . $key, $val);
            }
        }
        $stmt->execute();
        return $stmt;
    }
    public function query_lastid($sql, $params = [])
    {
        $stmt = $this->db->prepare($sql);
        if (!empty($params)) {
            foreach ($params as $key => $val) {
                $stmt->bindValue(':' . $key, $val);
            }
        }
        $stmt->execute();
        $lastid = $this->db->lastInsertId();
        return $lastid;
    }
    public function countRows($sql, $params = [])
    {
        $stmt = $this->db->prepare($sql);
        if (!empty($params)) {
            foreach ($params as $key => $val) {
                $stmt->bindValue(':' . $key, $val);
            }
        }
        $stmt->execute();
        $rows = $stmt->rowCount();
        return $rows;
    }
    public function rows($sql, $params = [])
    {
        $result = $this->query($sql, $params);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
    public function row($sql, $params = [])
    {
        $result = $this->query($sql, $params);
        return $result->fetch();
    }
    public function row_no_num($sql, $params = [])
    {
        $result = $this->query($sql, $params);
        return $result->fetch(PDO::FETCH_ASSOC);
    }
    public function column($sql, $params = [])
    {
        $result = $this->query($sql, $params);
        return $result->fetchColumn(PDO::FETCH_ASSOC);
    }
}
