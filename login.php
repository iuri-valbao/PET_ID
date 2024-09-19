<?php
session_start(); // Iniciar a sessão

// Inclui a conexão com o banco de dados
require 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        // Verifica se o e-mail existe no banco de dados
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && password_verify($password, $user['password_hash'])) {
            // Credenciais corretas, criar sessão
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            
            // Redirecionar para o dashboard
            header("Location: dashboard.php");
            exit;
        } else {
            // Credenciais inválidas
            echo "E-mail ou senha incorretos!";
        }
    } catch (PDOException $e) {
        echo "Erro ao processar login: " . $e->getMessage();
    }
}
?>