<?php
session_start();

require_once 'Database.php';

function checkIfPizzaExists() {
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])){
        return [
            'msg' => 'Id inválido, tente novamente.',
            'type'=> 'error'
        ];
    }
    $pizzaId = $_GET['id'];

    try {
        $pdo = Database::connect();

        $sql = "SELECT * FROM pizzas WHERE id = ?;";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$pizzaId]);
        $result = $stmt->fetch();

        if (!$result) {
            return [
                'msg' => 'Pizza não encontrada. Ela já foi comida ou nunca existiu',
                'type' => 'error'
            ];
        }
        return $result;

    } catch (PDOException $e) {
        return [
            'msg' => 'Erro de conexão, tente novamente.',
            'type' => 'error'
        ];
    }

    
}

function updatePizza(){
    $pizzaFlavor = $_POST['pizza_flavor'];
    $pizzaPrice = $_POST['pizza_price'];
    $pizzaId = $_GET['id'];

    if (empty(trim($pizzaFlavor)) || !is_numeric($pizzaPrice) || !is_numeric($_GET['id'])){
        return [
            'msg' => 'Dados inválidos, verifique e tente novamente.',
            'type' => 'error'
        ];
    }

    try {
        $pdo = Database::connect();

        $sql = "UPDATE pizzas SET flavor = ?, price = ? WHERE id = ?;";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$pizzaFlavor, $pizzaPrice, $pizzaId]);

        return [
            'msg' => 'Pizza atualizada com sucesso.',
            'type' => 'success'
        ];

    } catch (PDOException $e) {
        return [
            'msg' => 'Erro de conexão, tente novamente.',
            'type' => 'error'
        ];
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $result = updatePizza();
        if ($result){
            $_SESSION['flash_message'] = $result;
            header('Location: index.php');
            exit;
        }
    }

$result = checkIfPizzaExists();
if (isset($result['type']) && $result['type'] == 'error'){
    $_SESSION['flash_message'] = $result;
    header('Location: index.php');
    exit;
}

$pizza = $result;

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualizando a Pizza</title>
</head>
<body>
    <h1>Atualizando a Pizza</h1>

    <a href="index.php">Mostrar cardápio</a>

    <form action="" method="POST">
        <label for="pizza_flavor">Sabor</label>
        <input type="text" id="pizza_flavor" name="pizza_flavor" value="<?php echo $pizza['flavor']; ?>" required>

        <label for="pizza_price">Preço</label>
        <input type="number" id="pizza_price" name="pizza_price" step="0.01" value="<?php echo $pizza['price']; ?>" required>

        <button type="submit">Salvar Atualizações</button>
    </form>
</body>
</html>