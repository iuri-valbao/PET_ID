<?php
require 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $observations = $_POST['observations'];

    try {
        // Atualizar os dados pessoais do usuário
        $stmt = $pdo->prepare("UPDATE users SET name = :name, address = :address, phone = :phone, observations = :observations WHERE id = :user_id");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':observations', $observations);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();

        echo "Dados pessoais salvos com sucesso!";
        // Redirecionar para o dashboard
        header("Location: dashboard.php");
        exit;
    } catch (PDOException $e) {
        echo "Erro ao salvar dados: " . $e->getMessage();
    }
}
?>