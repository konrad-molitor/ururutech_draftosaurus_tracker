<?php
return [
    'host' => getenv('DB_HOST') ?: 'localhost',
    'username' => getenv('DB_USERNAME') ?: 'root',
    'password' => getenv('DB_PASSWORD') ?: '',
    'database' => getenv('DB_DATABASE') ?: 'DRAFTOSAURUS',
    'port' => getenv('DB_PORT') ?: 3306,
    'charset' => getenv('DB_CHARSET') ?: 'utf8mb4',
];
