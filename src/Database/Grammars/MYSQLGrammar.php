<?php

namespace PROJECT\Database\Grammars;

use App\Models\Model;

class MYSQLGrammar
{

    public static function buildInsertQuery($keys): string
    {
        $placeholders = "";
        for ($i = 1; $i <= count($keys); $i++) {
            $placeholders .= "?";
            if ($i < count($keys)) {
                $placeholders .= ", ";
            }
        }
        $query = "INSERT INTO " . Model::getTableName() . " (`" . implode('` ,`', $keys) . "`)";
        $query .= " VALUES (" . $placeholders . ")";
        return $query;
    }
    public static function buildSelectQuery($columns, $filter): string
    {
        if (is_array($columns)) {
            $columns = "`" . implode("`, `", $columns) . "`";
        }
        $query = "SELECT {$columns} FROM " . Model::getTableName();
        if ($filter) {
            $query .= " WHERE {$filter[0]} {$filter[1]} ?";
        }
        return $query;
    }

    public static function buildDeleteQuery(): string
    {
        return "DELETE FROM " . Model::getTableName() . " WHERE `user_id` = ?";
    }

    public static function buildUpdateQuery($keys): string
    {
        // Start the update query
        $query = "UPDATE " . Model::getTableName() . " SET ";

        // Loop through keys to build the SET part of the query
        foreach ($keys as $key) {
            $query .= "`{$key}` = ?, ";  // No quotes around the placeholder
        }
        // Remove the last comma and space, and add the WHERE clause
        return rtrim($query, ', ') . " WHERE user_id = ?";
    }

}