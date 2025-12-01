<?php

require_once 'Database.php';

echo "<h1>Teste de Conexão</h1>";

try {
    $pdo = Database::connect();
    
    $stmt = $pdo->query("SELECT table_name FROM information_schema.tables
        WHERE table_schema = 'public';
    ");
    
    $result = $stmt->fetchColumn();
    
    echo "O banco respondeu: <strong>$result</strong>";
    
    echo "<br><br>";
    var_dump($result);
} catch (PDOException $e) {
    die("Erro de conexão: " . $e->getMessage());
}
