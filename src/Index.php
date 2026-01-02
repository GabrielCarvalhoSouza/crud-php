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
    <link rel="stylesheet" href="styles/style.css">
    <title>Cardápio da Pizzaria</title>
</head>
<body>
        <header>
            <h1>Cardápio da Pizzaria</h1>
            <nav>
                <a href="create.php">Cadastre uma pizza</a>
            </nav>
        </header>
        <main>
            <div class="card">
                <?php
                    if (isset($_SESSION['flash_message'])):
                        $msg = $_SESSION['flash_message']['msg'];
                        $type = $_SESSION['flash_message']['type'];
                        $role = ($type === 'error') ? 'alert' : 'status';
                ?>
                <div class="flash-message" id="flash-message" role="<?php echo $role ?>">
                    <span> <?php echo $type . ": " . $msg; ?> </span>
                    <?php unset($_SESSION['flash_message']); ?>
                    <button id="btn--closeflash-message">X</button>
                </div>
                <?php endif; ?>
                <?php if (empty($result)): ?>
                    <p>Nenhuma pizza cadastrada ainda.</p>
                <?php
                    endif;
                    if (!empty($result)):
                ?>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Sabor</th>
                                <th>Preço</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($result as $pizza): ?>
                                <tr>
                                    <td> <?php echo $pizza['id']; ?> </td>
                                    <td> <?php echo htmlspecialchars($pizza['flavor'], ENT_QUOTES, 'UTF-8'); ?> </td>
                                    <td> R$ <?php echo htmlspecialchars($pizza['price'], ENT_QUOTES, 'UTF-8'); ?> </td>
                                    <td>
                                        <a class="btn btn-primary" href="update.php?id=<?php echo $pizza['id']; ?>">Atualizar</a>
                                        <form action="delete.php" method="post">
                                            <input type="hidden" name="id" value="<?php echo $pizza['id']; ?>">
                                            <button class="btn btn-danger" type="submit">Excluir</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </main>
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
