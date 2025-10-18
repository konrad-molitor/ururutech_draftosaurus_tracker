<?php

namespace App\Support;

use mysqli;
use RuntimeException;

class DatabaseConnection
{
    public static function make(): mysqli
    {
        $config = require __DIR__ . '/../../config/database.php';

        $mysqli = new mysqli(
            $config['host'],
            $config['username'],
            $config['password'],
            $config['database'],
            (int) $config['port']
        );

        if ($mysqli->connect_error) {
            throw new RuntimeException('Database connection failed: ' . $mysqli->connect_error);
        }

        if (!empty($config['charset'])) {
            $mysqli->set_charset($config['charset']);
        }

        return $mysqli;
    }
}
