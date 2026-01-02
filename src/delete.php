<?php
session_start();

require_once 'Database.php';

function deletePizza(){
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        return [
            'msg' => 'Requisição inválida, tente novamente',
            'type' => 'error'
        ];
    }

    if (!isset($_POST['id']) || !is_numeric($_POST['id'])){
        return [
            'msg' => 'Id inválido, tente novamente',
            'type'=> 'error'
        ];
    }
    $pizzaId = $_POST['id'];

    try {
        $pdo = Database::connect();

        $sql = "DELETE FROM pizzas WHERE id = ?;";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$pizzaId]);

        return [
            'msg' => 'Pizza excluida com sucesso',
            'type' => 'success'
        ];
    } catch (PDOException $e) {
        return [
            'msg' => 'Erro de conexão, tente novamente',
            'type' => 'error'
        ];
    }
}

$_SESSION['flash_message'] = deletePizza();
header('Location: index.php');
exit;