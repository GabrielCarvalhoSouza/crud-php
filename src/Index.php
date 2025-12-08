<?php
session_start();

require_once 'Database.php';

try {
    $pdo = Database::connect();

    $stmt = $pdo->query("SELECT * FROM pizzas");
    
    $result = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Erro de conexão: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu de Pizzaria</title>
</head>
<body>
    <header>
        <h1>Cardápio da Pizzaria</h1>
        <nav>
            <a href="create.php">Cadastre uma pizza</a>
        </nav>
    </header>

    <div class="flash-message" id="flash-message">
        <?php
            if (isset($_SESSION['flash_message'])):
                $msg = $_SESSION['flash_message']['msg'];
                $type = $_SESSION['flash_message']['type'];
        ?>
        <span> <?php echo $type . ": " . $msg; ?> </span>
        <?php unset($_SESSION['flash_message']); ?>
        <button id="btn--closeflash-message">X</button>
        <?php endif; ?>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Sabor</th>
                <th>Preço</th>
                <th>Excluir</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($result as $pizza): ?>
                <tr>
                    <td> <?php echo $pizza['id']; ?> </td>
                    <td> <?php echo $pizza['flavor']; ?> </td>
                    <td> R$ <?php echo $pizza['price']; ?> </td>
                    <td>
                        <a href="delete.php?id=<?php echo $pizza['id']; ?>">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            
            <?php if (empty($result)): ?>
                <tr>
                    <td colspan="4" style="text-align: center;">Nenhuma pizza cadastrada ainda.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const flashMessageBox = document.getElementById("flash-message");
            const closeFlashMessageBoxButton = document.getElementById("btn--closeflash-message");
            if (!flashMessageBox || !closeFlashMessageBoxButton) {
                return;
            }
            
            const removeFlashMessage = () => {
                flashMessageBox.remove();
            }
    
            let timeout = setTimeout(removeFlashMessage, 3000);
            closeFlashMessageBoxButton.onclick = () => {
                clearTimeout(timeout);
                removeFlashMessage();
            }
        });

    </script>
    
</body>
</html>
