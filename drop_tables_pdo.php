<?php
$host = 'localhost';
$db   = 'uas_web_2';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

$stmt = $pdo->query("SHOW TABLES");
$tables = $stmt->fetchAll(PDO::FETCH_COLUMN);

if (empty($tables)) {
    echo "No tables found.\n";
} else {
    // Disable foreign key checks
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
    
    foreach ($tables as $table) {
        echo "Dropping table $table...\n";
        $pdo->exec("DROP TABLE IF EXISTS `$table`");
    }
    
    // Enable foreign key checks
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 1");
    echo "All tables dropped.\n";
}
