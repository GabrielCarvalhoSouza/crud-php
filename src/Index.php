<?php

require_once 'Database.php';

echo "<h1>Teste de Conexão</h1>";

$pdo = Database::connect();

$stmt = $pdo->query("SELECT 1 + 1 as soma;");
$result = $stmt->fetchColumn();

echo "O banco respondeu: <strong>$result</strong>";

echo "<br><br>";
var_dump($result);