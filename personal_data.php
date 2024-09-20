<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

require 'db_connection.php';

$user_id = $_SESSION['user_id'];

// Busca os dados do usuário no banco de dados
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

// Atualiza os dados do usuário no banco de dados
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $notes = $_POST['notes'];

    try {
        $stmt = $pdo->prepare("UPDATE users SET name = :name, email = :email, address = :address, phone = :phone, notes = :notes WHERE id = :user_id");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':notes', $notes);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();

        // Redireciona para o dashboard após salvar
        header("Location: dashboard.php");
        exit;
    } catch (PDOException $e) {
        echo "Erro ao atualizar dados do usuário: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Dados Pessoais</title>
    <link rel="stylesheet" href="style.css">
    <style>
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

        form {
            width: 100%;
        }

        label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
        }

        input, textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        textarea {
            height: 100px;
        }

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
        <div class="section">
            <h2>Editar Dados Pessoais</h2>
            <form method="POST">
                <label for="name">Nome</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>

                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

                <label for="address">Endereço</label>
                <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($user['address']); ?>">

                <label for="phone">Telefone</label>
                <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>">

                <label for="notes">Observações</label>
                <textarea id="notes" name="notes"><?php echo htmlspecialchars($user['notes']); ?></textarea>

                <div class="button-container">
                    <button type="submit" class="button">Salvar Alterações</button>
                    <button type="button" class="button button-back" onclick="window.location.href='dashboard.php'">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>