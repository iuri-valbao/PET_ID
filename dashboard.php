<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

require 'db_connection.php';

$user_id = $_SESSION['user_id'];

// Recupera os dados do usuário logado
try {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :user_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$user) {
        echo "Usuário não encontrado.";
        exit;
    }
} catch (PDOException $e) {
    echo "Erro ao buscar dados do usuário: " . $e->getMessage();
    exit;
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
    <style>
        /* Estilos gerais */
        .container {
            width: 80%;
            margin: 0 auto;
        }

        .section {
            margin-bottom: 30px;
            padding: 20px;
            background-color: #f5f5f5;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .section h2 {
            color: #555;
            margin-bottom: 15px;
        }

        /* Estilos da tabela de dados do usuário */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        th {
            background-color: #e0e0e0;
            text-align: left;
        }

        td {
            text-align: left;
        }

        /* Estilos dos botões */
        .button-container {
            display: flex;
            justify-content: space-between;
        }

        .button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .button:hover {
            background-color: #0056b3;
        }

        .button-logout {
            background-color: #dc3545;
        }

        .button-logout:hover {
            background-color: #c82333;
        }

        /* Estilos dos botões dos animais */
        .animal-buttons {
            display: flex;
            flex-wrap: wrap;
        }

        .animal-buttons button {
            margin: 5px;
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .animal-buttons button:hover {
            background-color: #218838;
        }

        .add-animal-button {
            margin: 5px;
            padding: 10px 20px;
            background-color: #ffc107;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .add-animal-button:hover {
            background-color: #e0a800;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Parte Superior: Dados do Usuário -->
        <div class="section">
            <h2>Dados do Usuário</h2>
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
                    <td><?php echo htmlspecialchars($user['notes']); ?></td>
                </tr>
            </table>
            <div class="button-container">
                <button class="button" onclick="window.location.href='personal_data.php?user_id=<?php echo $user_id; ?>'">Editar Dados Pessoais</button>
                <button class="button button-logout" onclick="window.location.href='logout.php'">Sair</button>
            </div>
        </div>

        <!-- Parte Inferior: Animais Cadastrados -->
        <div class="section">
            <h2>Seus Animais Cadastrados</h2>
            <div class="animal-buttons">
                <?php if ($animals): ?>
                    <?php foreach ($animals as $animal): ?>
                        <button onclick="window.location.href='view_animal.php?animal_id=<?php echo $animal['id']; ?>'">
                            <?php echo htmlspecialchars($animal['name']); ?>
                        </button>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Você ainda não cadastrou nenhum animal.</p>
                <?php endif; ?>
                <button class="add-animal-button" onclick="window.location.href='add_animal.php'">Adicionar Animal</button>
            </div>
        </div>
    </div>
</body>
</html>