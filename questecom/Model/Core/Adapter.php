<?php

namespace Model\Core;

class Adapter
{
    private $config = [
        'host' => 'localhost',
        'user' => 'root',
        'password' => '',
        'database' => 'questecom',
    ];

    private $connect = null;
    public function connection()
    {
        $con = new \mysqli($this->config['host'], $this->config['user'], $this->config['password'], $this->config['database']);
        $this->setConnection($con);
    }

    public function isConnected()
    {
        if (!$this->getConnection()) {
            return false;
        }
        return true;
    }

    public function setConnection(\mysqli $con)
    {
        $this->connect = $con;
        return $this;
    }

    public function getConnection()
    {
        return $this->connect;
    }

    public function insert($query)
    {
        if (!$this->isConnected()) {
            $this->connection();
        }
        if (!$this->getConnection()->query($query)) {
            return false;
        }
        return $this->connect->insert_id;
    }

    public function update($query)
    {
        if (!$this->isConnected()) {
            $this->connection();
        }
        if (!$this->getConnection()->query($query)) {
            return false;
        }
        return true;
    }

    public function delete($query)
    {
        if (!$this->isConnected()) {
            $this->connection();
        }
        if (!$this->getConnection()->query($query)) {
            return false;
        }
        return true;
    }

    public function fetchRow($query)
    {
        if (!$this->isConnected()) {
            $this->connection();
        }
        if (!$result = $this->getConnection()->query($query)) {
            return false;
        }
        $row = $result->fetch_assoc();
        return $row;
    }

    public function fetchAll($query)
    {
        if (!$this->isConnected()) {
            $this->connection();
        }
        if (!$result = $this->getConnection()->query($query)) {
            return false;
        }
        $row = $result->fetch_all(MYSQLI_ASSOC);
        return $row;
    }

    public function fetchPairs($query)
    {
        if (!$this->isConnected()) {
            $this->connection();
        }
        $result = $this->getConnection()->query($query);
        $rows = $result->fetch_all();
        if (!$rows) {
            return $rows;
        }

        $columns = array_column($rows, '0');
        $values = array_column($rows, '1');
        return array_combine($columns, $values);
    }

    public function count($query)
    {
        if (!$this->getConnection()) {
            $this->connection();
        }
        if (!$result = $this->getConnection()->query($query)) {
            return false;
        }
        return $result->num_rows;
    }

    public function query($query)
    {
        if (!$this->isConnected()) {
            $this->connection();
        }
        return $this->connect->query($query);
    }

}
