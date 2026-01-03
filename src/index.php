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
            <div class="wrapper">
                <h1>Cardápio da Pizzaria</h1>
                <nav>
                    <a href="create.php">Cadastre uma pizza</a>
                </nav>
            </div>
        </header>
        <main>
            <div class="card">
                <?php
                    if (isset($_SESSION['flash_message'])):
                        $msg = $_SESSION['flash_message']['msg'];
                        $type = $_SESSION['flash_message']['type'];
                        $role = ($type === 'error') ? 'alert' : 'status';
                ?>
                <div class="flash-message <?php echo $type ?>" id="flash-message" role="<?php echo $role ?>">
                    <span> <?php echo $msg; ?> </span>
                    <?php unset($_SESSION['flash_message']); ?>
                    <button id="btn-close-flash-message">X</button>
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
                                <th class="col-id">ID</th>
                                <th class="col-flavor">Sabor</th>
                                <th class="col-price">Preço</th>
                                <th class="col-actions">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($result as $pizza): ?>
                                <tr>
                                    <td class="col-id"> <?php echo $pizza['id']; ?> </td>
                                    <td class="col-flavor"> <?php echo htmlspecialchars($pizza['flavor'], ENT_QUOTES, 'UTF-8'); ?> </td>
                                    <td class="col-price"> R$ <?php echo htmlspecialchars($pizza['price'], ENT_QUOTES, 'UTF-8'); ?> </td>
                                    <td class="col-actions">
                                        <a class="btn btn-primary" href="update.php?id=<?php echo $pizza['id']; ?>">Alterar</a>
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
        <footer>
            <p>Desenvolvido por Gabriel Carvalho</p>
        </footer>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const flashMessageBox = document.getElementById("flash-message");
            const closeFlashMessageBoxButton = document.getElementById("btn-close-flash-message");

            if (!flashMessageBox || !closeFlashMessageBoxButton) {
                return;
            }

            const removeImmediately = () => {
                flashMessageBox.remove();
            }

            const animateAndRemove = () => {
                flashMessageBox.classList.add('hiding');
                flashMessageBox.addEventListener('animationend', () => {
                    flashMessageBox.remove();
                });
            }

            let timeout = setTimeout(animateAndRemove, 4000);

            closeFlashMessageBoxButton.onclick = () => {
                clearTimeout(timeout);
                removeImmediately();
            }
        });
    </script>
</body>
</html>
