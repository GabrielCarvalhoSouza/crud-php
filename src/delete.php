<?php

require_once 'Database.php';

function deletePizza(){
    if ($_SERVER['REQUEST_METHOD'] != 'GET') {
        return;
    }

    $pizzaId = $_GET['id'];
    if (!is_numeric($pizzaId)){
        return;
    }

    try {
        $pdo = Database::connect();

        $sql = "DELETE FROM pizzas WHERE id = ?;";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$pizzaId]);
    } catch (PDOException $e) {
    return;
    }
}

deletePizza();
header('Location: index.php');
exit;