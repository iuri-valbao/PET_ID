<?php
// Configurações do banco de dados
$host = 'localhost:3306'; // Endereço do servidor MySQL
$dbname = 'pet_id'; // Nome do banco de dados
$username = 'root'; // Usuário do MySQL (ajuste conforme necessário)
$password = ''; // Senha do MySQL (ajuste conforme necessário)

// Criando a conexão
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    // Configura PDO para lançar exceções em caso de erro
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Caso a conexão falhe, exibirá uma mensagem de erro
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}
?>