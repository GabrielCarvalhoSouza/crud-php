<?php
session_start();

require_once 'Database.php';

function createPizza(){
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        return null;
    }

    $pizzaFlavor = $_POST['pizza_flavor'];
    $pizzaPrice = $_POST['pizza_price'];

    if (empty(trim($pizzaFlavor)) || !is_numeric($pizzaPrice)){
        return [
            'msg' => 'Dados inválidos, verifique e tente novamente',
            'type' => 'error'
        ];
    }

    try {
        $pdo = Database::connect();

        $sql = "INSERT INTO pizzas (flavor, price) VALUES (?, ?);";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$pizzaFlavor, $pizzaPrice]);

        return [
            'msg' => 'Pizza cadastrada com sucesso',
            'type' => 'success'
        ];

    } catch (PDOException $e) {
        return [
            'msg' => 'Erro de conexão, tente novamente',
            'type' => 'error'
        ];
    }
}

$result = createPizza();
if ($result){
    $_SESSION['flash_message'] = $result;
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style.css">
    <title>Cadastro de Pizza</title>
</head>
<body>
    <header>
        <h1>Cadastro de Pizza</h1>
        <nav>
            <a href="index.php">Mostrar cardápio</a>
        </nav>
    </header>
    <main>
        <div class="card">
            <form class="form" action="" method="POST" autocomplete="off">
                <div class="input-group">
                    <label for="pizza_flavor">Sabor</label>
                    <input type="text" id="pizza_flavor" name="pizza_flavor" required>
                </div>
                <div class="input-group">
                    <label for="pizza_price">Preço</label>
                    <input type="number" id="pizza_price" name="pizza_price" step="0.01" required>
                </div>
                <button class="btn btn-primary" type="submit">Cadastrar</button>
            </form>
        </div>
    </main>
</body>
</html>