<?php
/**
 * FYI Loginscript
 * (c) 2021 by bastie.space <bastian.luettig@bastie.space>
 * www.bastie.space
 */

namespace App\Services;


class SqliteService
{
    private string $_filename = './db/db.sqlite';
    static ?SqliteService $instance = null;
    private ?\SQLite3 $db;

    static function getInstance(): ?SqliteService
    {
        if (self::$instance === null) {
            self::$instance = new SqliteService();
        }
        return self::$instance;
    }

    private function __construct()
    {
        $this->db = new \SQLite3($this->_filename);
    }

    public function querySingle($query)
    {
        return $this->db->querySingle($query, true);
    }

    public function query($query)
    {
        return $this->db->query($query);
    }

    public function lastInsertRowID(): int
    {
        return $this->db->lastInsertRowID();
    }
}