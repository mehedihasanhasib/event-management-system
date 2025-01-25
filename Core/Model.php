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
    protected $result;

    public function __construct()
    {
        $this->pdo = Database::getInstance();
    }

    public function first()
    {
        return $this->result[0] ?? [];
    }

    public function get()
    {
        return $this->result ?? [];
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

        return $result;
    }

    // public function hideColumns($row)
    // {
    //     // Loop through the hidden columns array and unset them from the row
    //     foreach ($this->hidden as $column) {
    //         unset($row[$column]);
    //     }
    //     return $row; // Return the row with hidden columns removed
    // }

    public function update($id, $data)
    {
        $columns = '';
        foreach ($data as $key => $value) {
            $columns .= "{$key} = :{$key}, ";
        }
        $columns = rtrim($columns, ', ');

        $data[$this->primaryKey] = $id;

        $stmt = $this->pdo->prepare("UPDATE {$this->table} SET {$columns} WHERE {$this->primaryKey} = :{$this->primaryKey}");
        return $stmt->execute($data);
    }

    public function where($column, $value)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE {$column} = :val");
        $stmt->execute(['val' => $value]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->result = $result;

        return $this;
    }

    public function paginate($page_no, $limit)
    {
        $offset = ($page_no - 1) * $limit;

        // Fetch total count for pagination metadata
        $stmt = $this->pdo->query("SELECT COUNT(*) AS total FROM {$this->table}");
        $totalRecords = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        $totalPages = ceil($totalRecords / $limit);

        // Fetch paginated results
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return [
            'data' => $results,
            'pagination' => [
                'current_page' => $page_no,
                'total_pages' => $totalPages,
                'total_records' => $totalRecords,
            ],
        ];
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE {$this->primaryKey} = :id");
        return $stmt->execute(['id' => $id]);
    }
}
