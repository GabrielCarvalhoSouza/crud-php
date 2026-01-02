<?php

require_once 'Database.php';

try {
    $pdo = Database::connect();

    $pdo->exec("DROP TABLE IF EXISTS pizzas");

    $sql = "CREATE TABLE IF NOT EXISTS pizzas (
        id SERIAL PRIMARY KEY,
        flavor VARCHAR(255) NOT NULL,
        price DECIMAL(10, 2) NOT NULL
    )";

    $pdo->exec($sql);

    echo "Tabela criada (ou resetada) com sucesso!";
    echo "<br><a href=\"index.php\">Ir para o cardápio</a>";

} catch (PDOException $e) {
    die("Erro de conexão: " . $e->getMessage());
}
