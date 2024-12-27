<?php

namespace PROJECT\Database\Managers;

use App\Models\Model;
use PROJECT\Database\Grammars\SQLITEGrammar;
use PROJECT\Database\Managers\Contracts\DatabaseManager;

class SQLITEManager implements DatabaseManager
{
  protected static $instance = null;

  public function connect(): \PDO
  {
    try {
      if (!self::$instance) {
        self::$instance = new \PDO("sqlite:../database/SQLITE/database.db");
      }
    } catch (\PDOException $e) {
      echo "Error connecting " . $e->getMessage();
    }
    return self::$instance;
  }
  /**
   * Executes a SQL query with optional parameter binding.
   *
   * This function prepares and executes a SQL query, optionally binding values
   * to placeholders in the query. It then fetches and returns all results.
   *
   * @param string $query The SQL query to execute.
   * @param array $values An optional array of values to bind to the query placeholders.
   *
   * @return array An array of associative arrays representing the query results.
   *               Each inner array represents a row with column names as keys.
   */
  public function query(string $query, $values = [])
  {
    $stm = self::$instance->prepare($query);
    if (isset($values))
      for ($i = 1; $i <= count($values); $i++) {
        $stm->bindValue($i, $values[$i - 1]);
      }
    $stm->execute();
    return $stm->fetchAll(\PDO::FETCH_ASSOC);
  }
  /**
   * Creates a new record in the database.
   *
   * This function builds an INSERT query using the provided data,
   * prepares the statement, binds the values, and executes the query.
   *
   * @param array $data An associative array containing the column names as keys
   *                    and the values to be inserted.
   *
   * @return bool Returns TRUE on success or FALSE on failure.
   */
  public function create($data)
  {
    $query = SQLITEGrammar::buildInsertQuery(array_keys($data));
    $stm = self::$instance->prepare($query);
    $values = array_values($data);
    for ($i = 1; $i <= count($values); $i++) {
      $stm->bindValue($i, $values[$i - 1]);
    }
    return $stm->execute();
  }

  public function read($columns = '*', $filter = null)
  {
    $query = SQLITEGrammar::buildSelectQuery($columns, $filter);
    $stm = self::$instance->prepare($query);
    if ($filter) {
      $stm->bindValue(1, $filter[2]);
    }
    $stm->execute();
    return $stm->fetchAll(\PDO::FETCH_CLASS, Model::getModel());
  }

  public function update($column, $value, $data)
  {
    $query = SQLITEGrammar::buildUpdateQuery($column, array_keys($data));
    $stm = self::$instance->prepare($query);
    $values = array_values($data);
    for ($i = 1; $i <= count($values); $i++) {
      $stm->bindValue($i, $values[$i - 1]);
      if ($i == count($values)) {
        $stm->bindValue($i + 1, $value);
      }
    }
    return $stm->execute();
  }

  public function delete($id)
  {
    $query = SQLITEGrammar::buildDeleteQuery();
    $stm = self::$instance->prepare($query);
    $stm->bindValue(1, $id);
    return $stm->execute();
  }
}
