<?php

require_once 'Database.php';

echo "<h1>Teste de Conexão</h1>";

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
    <h1>Cardápio da Pizzaria</h1>

    <a href="create.php">Cadastre uma pizza</a>

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
    
    
</body>
</html>
