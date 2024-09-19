<?php
// Inclua a conexão com o banco de dados
require 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Verifique se o e-mail já está cadastrado
    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            echo "E-mail já cadastrado!";
            exit;
        }

        // Verificar se a senha tem no mínimo 8 caracteres, incluindo letras e números
        if (strlen($password) < 8 || !preg_match("/[A-Za-z]/", $password) || !preg_match("/[0-9]/", $password)) {
            echo "A senha deve ter no mínimo 8 caracteres, incluindo letras e números.";
            exit;
        }

        // Criptografar a senha
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // Inserir novo usuário no banco de dados
        $stmt = $pdo->prepare("INSERT INTO users (email, password_hash) VALUES (:email, :password_hash)");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password_hash', $password_hash);
        $stmt->execute();

        // Capturar o ID do novo usuário
        $user_id = $pdo->lastInsertId();

        // Redirecionar para a página de cadastro de dados pessoais com o ID do usuário
        header("Location: personal_data.php?user_id=" . $user_id);
        exit;
    } catch (PDOException $e) {
        echo "Erro ao criar conta: " . $e->getMessage();
    }
}
?>