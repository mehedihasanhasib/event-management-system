<?php

namespace Models;

use PDO;
use Core\Database;

class Model
{
    protected $table;
    protected $primaryKey = 'id';
    protected $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance();
    }

    public function all()
    {
        $stmt = $this->pdo->query("SELECT * FROM {$this->table}");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE {$this->primaryKey} = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $columns = implode(',', array_keys($data));
        $placeholders = ':' . implode(',:', array_keys($data));

        $stmt = $this->pdo->prepare("INSERT INTO {$this->table} ($columns) VALUES ($placeholders)");
        return $stmt->execute($data);
    }

    // public function update($id, $data) {
    //     $columns = '';
    //     foreach ($data as $key => $value) {
    //         $columns .= "{$key} = :{$key}, ";
    //     }
    //     $columns = rtrim($columns, ', ');

    //     $data[$this->primaryKey] = $id; // Add the primary key to the parameters

    //     $stmt = $this->pdo->prepare("UPDATE {$this->table} SET {$columns} WHERE {$this->primaryKey} = :{$this->primaryKey}");
    //     return $stmt->execute($data);
    // }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE {$this->primaryKey} = :id");
        return $stmt->execute(['id' => $id]);
    }
}
