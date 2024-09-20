<?php
// Configurações do banco de dados
$host = 'sql11.infinityfree.com'; // Endereço do servidor MySQL
$dbname = 'if0_37350335_pet_id'; // Nome do banco de dados
$username = 'if0_37350335_pet_id'; // Usuário do MySQL (ajuste conforme necessário)
$password = '45tg99hcr'; // Senha do MySQL (ajuste conforme necessário)

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