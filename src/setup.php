<?php

require_once 'Database.php';

try {
    $pdo = Database::connect();

    $sql = "CREATE TABLE IF NOT EXISTS pizzas (
        id SERIAL PRIMARY KEY,
        nome VARCHAR(255) NOT NULL,
        preco DECIMAL(10, 2) NOT NULL
    )";

    $pdo->exec($sql);

    echo "Tabela criada com sucesso (ou já foi criada anteriormente)";

} catch (PDOException $e) {
    die("Erro de conexão: " . $e->getMessage());
}
