<?php

// Load framework
require __DIR__ . '/app/Config/Paths.php';
$paths = new Config\Paths();
require $paths->systemDirectory . '/Boot.php';
CodeIgniter\Boot::bootWeb($paths);

$db = \Config\Database::connect();
$forge = \Config\Database::forge();

$tables = $db->listTables();

foreach ($tables as $table) {
    echo "Dropping table $table...\n";
    $forge->dropTable($table, true, true); // IF EXISTS, CASCADE
}

echo "All tables dropped. You can now run php spark migrate.\n";
