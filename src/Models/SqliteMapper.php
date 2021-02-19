<?php
/**
 * FYI Loginscript
 * (c) 2021 by bastie.space <bastian.luettig@bastie.space>
 * www.bastie.space
 */

namespace App\Models;


use App\Services\SqliteService;

class SqliteMapper
{
    protected ?SqliteService $db;

    public function __construct()
    {
        $this->db = SqliteService::getInstance();
    }

    public function Get($table, $where)
    {
        return $this->db->querySingle("SELECT *, rowid as id FROM `$table` WHERE $where LIMIT 1");
    }

    public function List($table, $where = null, $order_by = null)
    {
        $rows = [];
        $query = "SELECT *, rowid as id FROM `$table`";
        if ($where) {
            $query .= " WHERE $where";
        }
        if ($order_by) {
            $query .= " ORDER BY $order_by";
        }
        $get = $this->db->query($query);
        while ($data = $get->fetchArray()) {
            $rows[] = $data;
        }
        return $rows;
    }

    public function QuerySingle($query) {
        return $this->db->querySingle($query);
    }

    public function QueryList($query)
    {
        $rows = [];
        $get = $this->db->query("$query");
        while ($data = $get->fetchArray()) {
            $rows[] = $data;
        }
        return $rows;
    }

    public function Delete($table, $where) {
        return $this->db->query("DELETE FROM `$table` WHERE $where");
    }

    public function Update($table, $update_array, $where, $escape = false): \SQLite3Result
    {
        $updates = [];
        foreach ($update_array as $key => $value) {
            if ($escape)
                $updates[] = "`$key`='$value'";
            else
                $updates[] = "`$key`=$value";

        }
        $update_string = implode(",", $updates);
        return $this->db->query("UPDATE `$table` SET $update_string WHERE $where");
    }


    public function Insert($table, $data)
    {
        $keys = implode(",", array_keys($data));
        $values = "";
        foreach ($data as $value)
            $values .= "'" . $value . "',";
        $values = substr($values, 0, -1);
        $this->db->query("INSERT INTO `$table` ($keys) VALUES($values)");
        $lastId = $this->db->lastInsertRowID();
        return $this->Get($table, "`rowid` = $lastId");
    }
}