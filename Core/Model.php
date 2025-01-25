<?php

namespace Core;

use PDO;
use Core\Database;

class Model
{
    protected $table;
    protected $primaryKey = 'id';
    protected $hidden = [];
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
        $stmt->execute($data);
        $lastInsertId = $this->pdo->lastInsertId();
        $primaryKey = $this->primaryKey;
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE {$primaryKey} = :id");
        $stmt->execute(['id' => $lastInsertId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $this->hideColumns($result);
    }

    public function hideColumns($row)
    {
        // Loop through the hidden columns array and unset them from the row
        foreach ($this->hidden as $column) {
            unset($row[$column]);
        }
        return $row; // Return the row with hidden columns removed
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

    public function where($column, $value)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE {$column} = :val");
        $stmt->execute(['val' => $value]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE {$this->primaryKey} = :id");
        return $stmt->execute(['id' => $id]);
    }
}
