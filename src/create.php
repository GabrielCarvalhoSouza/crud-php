<?php

require_once 'Database.php';

function createPizza(){
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        return;
    }

    $pizza_flavor = $_POST['pizza_flavor'];
    $pizza_price = $_POST['pizza_price'];

    if (empty(trim($pizza_flavor)) || !is_numeric($pizza_price)){
        echo "Erro: Dados inválidos, tente novamente.";
        return;
    }

    try {
        $pdo = Database::connect();

        $sql = "INSERT INTO pizzas (flavor, price) VALUES (?, ?);";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$pizzaFlavor, $pizza_price]);

        echo "Pizza cadastrada.";

    } catch (PDOException $e) {
        die("Erro de conexão: " . $e->getMessage());
    }
}

createPizza();

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Pizza</title>
</head>
<body>
    <h1>Cadastro de Pizza</h1>

    <a href="index.php">Mostrar cadastro</a>

    <form action="" method="POST">
        <label for="pizza_flavor">Sabor</label>
        <input type="text" id="pizza_flavor" name="pizza_flavor" required>

        <label for="pizza_price">Preço</label>
        <input type="number" id="pizza_price" name="pizza_price" step="0.01" required>

        <button type="submit">Cadastrar</button>
    </form>
</body>
</html>