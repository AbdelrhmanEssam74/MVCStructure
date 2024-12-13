<?php

namespace PROJECT\Database\Managers;

use App\Models\Model;
use PROJECT\Database\Grammars\MYSQLGrammar;
use PROJECT\Database\Grammars\SQLITEGrammar;
use PROJECT\Database\Managers\Contracts\DatabaseManager;

class SQLITEManager implements DatabaseManager
{
    protected static $instance = null;

    public function connect(): \PDO
    {
        try {
            if (!self::$instance) {
                self::$instance = new \PDO("sqlite:database.db");
            }

        } catch (\PDOException $e) {
            echo "Error connecting " . $e->getMessage();
        }
        return self::$instance;
    }


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

    public function update($id, $data)
    {
        $query = SQLITEGrammar::buildUpdateQuery(array_keys($data));
        $stm = self::$instance->prepare($query);
        $values = array_values($data);
        for ($i = 1; $i <= count($values); $i++) {
            $stm->bindValue($i, $values[$i - 1]);
            if ($i == count($values)) {
                $stm->bindValue($i + 1, $id);
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