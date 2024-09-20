<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

require 'db_connection.php';

$animal_id = $_GET['animal_id'];
$user_id = $_SESSION['user_id'];

// Verifica se o animal pertence ao usuário logado
try {
    $stmt = $pdo->prepare("SELECT * FROM animals WHERE id = :animal_id AND user_id = :user_id");
    $stmt->bindParam(':animal_id', $animal_id);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $animal = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$animal) {
        echo "Animal não encontrado ou você não tem permissão para visualizá-lo.";
        exit;
    }
} catch (PDOException $e) {
    echo "Erro ao buscar dados do animal: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Pet ID - Visualizar Animal</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Estilos para o layout de visualização dos dados do animal */
        .container {
            width: 60%;
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

        .button-back {
            background-color: #6c757d;
        }

        .button-back:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Parte de visualização dos dados do animal -->
        <div class="section">
            <h2>Dados do Animal: <?php echo htmlspecialchars($animal['name']); ?></h2>
            <table>
                <tr>
                    <th>Nome</th>
                    <td><?php echo htmlspecialchars($animal['name']); ?></td>
                </tr>
                <tr>
                    <th>Data de Nascimento</th>
                    <td><?php echo htmlspecialchars($animal['birth_date']); ?></td>
                </tr>
                <tr>
                    <th>Espécie</th>
                    <td><?php echo htmlspecialchars($animal['species']); ?></td>
                </tr>
                <tr>
                    <th>Raça</th>
                    <td><?php echo htmlspecialchars($animal['breed']); ?></td>
                </tr>
                <tr>
                    <th>Carteira de Vacinação</th>
                    <td>
                        <?php if ($animal['vaccination_card']): ?>
                            <a href="uploads/<?php echo htmlspecialchars($animal['vaccination_card']); ?>" target="_blank">Ver Carteira de Vacinação</a>
                        <?php else: ?>
                            Não disponível
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <th>Foto</th>
                    <td>
                        <?php if ($animal['photo']): ?>
                            <img src="uploads/<?php echo htmlspecialchars($animal['photo']); ?>" alt="Foto do Animal" style="width: 200px;">
                        <?php else: ?>
                            Não disponível
                        <?php endif; ?>
                    </td>
                </tr>
            </table>
        </div>

        <div class="button-container">
            <!-- Botão para editar os dados do animal -->
            <button class="button" onclick="window.location.href='edit_animal.php?animal_id=<?php echo $animal['id']; ?>'">Editar Dados</button>

            <!-- Botão para voltar ao dashboard -->
            <button class="button button-back" onclick="window.location.href='dashboard.php'">Voltar ao Dashboard</button>
        </div>
    </div>
</body>
</html>