<?php
$host = 'db.ojmgozpgzqdt1uahwunl.supabase.co';
$port = 5432;
$database = 'postgres';
$user = 'postgres';
$password = 'P0ydUkGx72Eirpg';

echo "=== Testing Supabase Connection ===\n";
echo "Host: $host\n";
echo "User: $user\n";
echo "Database: $database\n\n";

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$database;sslmode=require";
    echo "DSN: $dsn\n";
    echo "Connecting...\n";
    
    $pdo = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_TIMEOUT => 5
    ]);
    
    echo "✓ Connection SUCCESS!\n";
    
    // Test query
    $result = $pdo->query('SELECT 1 as test');
    $row = $result->fetch();
    echo "✓ Query test: " . $row['test'] . "\n";
    
    $pdo = null;
    echo "\n✓ ALL OK - Ready to deploy!\n";
    
} catch (PDOException $e) {
    echo "✗ Connection FAILED!\n";
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
    exit(1);
}
?>
