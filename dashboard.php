<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

require 'db_connection.php';

$user_id = $_SESSION['user_id'];

// Recupera os dados do usuário
try {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :user_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erro ao buscar dados do usuário: " . $e->getMessage();
}

// Recupera os animais do usuário
try {
    $stmt = $pdo->prepare("SELECT * FROM animals WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $animals = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erro ao buscar animais: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Pet ID - Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <!-- Parte Superior: Dados do Usuário -->
        <div class="user-data">
            <h1>Bem-vindo, <?php echo htmlspecialchars($user['name']); ?>!</h1>
            <h2>Seus dados</h2>
            <table>
                <tr>
                    <th>Nome</th>
                    <td><?php echo htmlspecialchars($user['name']); ?></td>
                </tr>
                <tr>
                    <th>E-mail</th>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                </tr>
                <tr>
                    <th>Endereço</th>
                    <td><?php echo htmlspecialchars($user['address']); ?></td>
                </tr>
                <tr>
                    <th>Telefone</th>
                    <td><?php echo htmlspecialchars($user['phone']); ?></td>
                </tr>
                <tr>
                    <th>Observações</th>
                    <td><?php echo htmlspecialchars($user['observations']); ?></td>
                </tr>
            </table>
            <button onclick="window.location.href='personal_data.php?user_id=<?php echo $user_id; ?>'">Editar Dados Pessoais</button>
        </div>

        <!-- Divisão visual -->
        <hr>

        <!-- Parte Inferior: Animais Cadastrados -->
        <div class="animal-data">
            <h2>Seus animais cadastrados</h2>
            <div class="animal-buttons">
                <?php if ($animals): ?>
                    <?php foreach ($animals as $animal): ?>
                        <button onclick="window.location.href='edit_animal.php?animal_id=<?php echo $animal['id']; ?>'">
                            <?php echo htmlspecialchars($animal['name']); ?>
                        </button>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Você ainda não cadastrou nenhum animal.</p>
                <?php endif; ?>
            </div>
            <button onclick="window.location.href='add_animal.php'">Adicionar Animal</button>
        </div>
    </div>
</body>
</html>