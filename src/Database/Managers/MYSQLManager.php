<?php

namespace PROJECT\Database\Managers;

use App\Models\Model;
use PROJECT\Database\Grammars\MYSQLGrammar;
use PROJECT\Database\Managers\Contracts\DatabaseManager;

class MYSQLManager implements DatabaseManager
{
  protected static $instance = null;

  public function connect(): \PDO
  {
    if (!self::$instance) {
      self::$instance = new \PDO(env('DB_DRIVER') . ":host=" . env("DB_HOST") . ";dbname=" . env("DB_Database"), env("DB_USERNAME"), env("DB_PASSWORD"));
    }
    return self::$instance;
  }

  public function query(string $query, $values = [])
  {
    $stm = self::$instance->prepare($query);
    for ($i = 1; $i <= count($values); $i++) {
      $stm->bindValue($i, $values[$i - 1]);
    }
    $stm->execute();
    return $stm->fetchAll(\PDO::FETCH_OBJ);
  }

  /**
   * @param $data ["Column Name" => "Value"]
   * @return mixed
   */
  public function create($data): mixed
  {
    $query = MYSQLGrammar::buildInsertQuery(array_keys($data));
    $stm = self::$instance->prepare($query);
    $values = array_values($data);
    for ($i = 1; $i <= count($values); $i++) {
      $stm->bindValue($i, $values[$i - 1]);
    }
    return $stm->execute();
  }

  /**
   * @param $columns => ["column1", "column2" , ...]
   * @param $filter => ["where_condition", "operator", "value"]
   * @return string
   */
  public function read($columns = '*', $filter = null): mixed
  {
    $query = MYSQLGrammar::buildSelectQuery($columns, $filter);
    $stm = self::$instance->prepare($query);
    if ($filter) {
      $stm->bindValue(1, $filter[2]);
    }
    $stm->execute();
    return  $stm->fetchAll(\PDO::FETCH_CLASS, Model::getModel());
  }

  public function update($column, $value, $data)
  {
    $query = MYSQLGrammar::buildUpdateQuery($column, array_keys($data));
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

  public function delete($column, $value)
  {
    $query = MYSQLGrammar::buildDeleteQuery($column);
    $stm = self::$instance->prepare($query);
    $stm->bindValue(1, $value);
    return $stm->execute();
  }
}
