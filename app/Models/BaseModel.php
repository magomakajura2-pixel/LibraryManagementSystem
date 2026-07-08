<?php
declare(strict_types=1);

namespace App\Models;

use App\Config\Database;
use PDO;
use PDOStatement;

/**
 * BaseModel
 *
 * Thin data-access layer over PDO. Every query in the system flows through
 * these helpers, and every one of them uses prepared statements with bound
 * parameters — there is no string concatenation of user input into SQL.
 *
 * Child models declare $table and $primaryKey and inherit generic CRUD.
 */
abstract class BaseModel
{
    protected PDO $db;

    /** Table this model maps to. */
    protected string $table = '';

    /** Primary-key column for this table. */
    protected string $primaryKey = 'id';

    public function __construct()
    {
        $this->db = Database::connection();
    }

    /* --------------------------------------------------------------------- */
    /*  Low-level prepared-statement helpers                                  */
    /* --------------------------------------------------------------------- */

    /** Prepare + execute a statement with bound params. */
    protected function run(string $sql, array $params = []): PDOStatement
    {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    /** Fetch all rows for a query. */
    protected function select(string $sql, array $params = []): array
    {
        return $this->run($sql, $params)->fetchAll();
    }

    /** Fetch a single row (or null). */
    protected function selectOne(string $sql, array $params = []): ?array
    {
        $row = $this->run($sql, $params)->fetch();
        return $row === false ? null : $row;
    }

    /** Fetch a single scalar value (or null). */
    protected function scalar(string $sql, array $params = [])
    {
        $value = $this->run($sql, $params)->fetchColumn();
        return $value === false ? null : $value;
    }

    /* --------------------------------------------------------------------- */
    /*  Generic CRUD (all parameterised)                                      */
    /* --------------------------------------------------------------------- */

    /** Return every row in the table. */
    public function all(string $orderBy = null): array
    {
        $sql = "SELECT * FROM {$this->table}";
        if ($orderBy !== null) {
            $sql .= ' ORDER BY ' . $orderBy;   // caller-controlled, never user input
        }
        return $this->select($sql);
    }

    /** Find a single row by primary key. */
    public function find(int $id): ?array
    {
        return $this->selectOne(
            "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = :id",
            [':id' => $id]
        );
    }

    /**
     * Insert an associative array of column => value.
     * Column names come from the model (trusted); values are always bound.
     */
    public function insert(array $data): int
    {
        $columns      = array_keys($data);
        $placeholders = array_map(static fn ($c) => ':' . $c, $columns);

        $sql = sprintf(
            'INSERT INTO %s (%s) VALUES (%s)',
            $this->table,
            implode(', ', $columns),
            implode(', ', $placeholders)
        );

        $params = [];
        foreach ($data as $col => $val) {
            $params[':' . $col] = $val;
        }
        $this->run($sql, $params);

        return (int) $this->db->lastInsertId();
    }

    /** Update a row by primary key with an associative array of changes. */
    public function update(int $id, array $data): int
    {
        $assignments = array_map(static fn ($c) => "{$c} = :{$c}", array_keys($data));

        $sql = sprintf(
            'UPDATE %s SET %s WHERE %s = :__pk',
            $this->table,
            implode(', ', $assignments),
            $this->primaryKey
        );

        $params = [':__pk' => $id];
        foreach ($data as $col => $val) {
            $params[':' . $col] = $val;
        }
        return $this->run($sql, $params)->rowCount();
    }

    /** Delete a row by primary key. */
    public function delete(int $id): int
    {
        return $this->run(
            "DELETE FROM {$this->table} WHERE {$this->primaryKey} = :id",
            [':id' => $id]
        )->rowCount();
    }

    /* --------------------------------------------------------------------- */
    /*  Transaction passthroughs                                              */
    /* --------------------------------------------------------------------- */

    public function beginTransaction(): void { $this->db->beginTransaction(); }
    public function commit(): void           { $this->db->commit(); }
    public function rollBack(): void         { if ($this->db->inTransaction()) $this->db->rollBack(); }
}
