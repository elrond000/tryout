<?php
require __DIR__ . '/../vendor/autoload.php';

use Kassa\Database;

$pdo = Database::getConnection();
$files = glob(__DIR__ . '/../migrations/*.sql');
sort($files);
foreach ($files as $file) {
    $sql = file_get_contents($file);
    $pdo->exec($sql);
}
echo "Migrations run\n";
