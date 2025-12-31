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
    $pizzaId = $_POST['id'];

    if (empty(trim($pizzaFlavor)) || !is_numeric($pizzaPrice) || !is_numeric($_POST['id'])){
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
    <link rel="stylesheet" href="styles/style.css">
    <title>Atualização da Pizza</title>
</head>
<body>
    <header>
        <h1>Atualizando a Pizza</h1>
        <nav>
            <a href="index.php">Mostrar cardápio</a>
        </nav>
    </header>
    <main>
        <div class="card">
            <form action="" method="POST" autocomplete="off">
                <input type="hidden" name="id" value="<?php echo $pizza['id']; ?>">
                <label for="pizza_flavor">Sabor</label>
                <input type="text" id="pizza_flavor" name="pizza_flavor" value="<?php echo htmlspecialchars($pizza['flavor'], ENT_QUOTES, 'UTF-8'); ?>" required>
                <label for="pizza_price">Preço</label>
                <input type="number" id="pizza_price" name="pizza_price" step="0.01" value="<?php echo htmlspecialchars($pizza['price'], ENT_QUOTES, 'UTF-8'); ?>" required>
                <button type="submit">Salvar</button>
                <button type="reset">Desfazer</button>
            </form>
        </div>
    </main>
</body>
</html>