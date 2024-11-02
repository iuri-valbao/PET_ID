<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

require 'db_connection.php';

$user_id = $_SESSION['user_id'];

// Processa o formulário de adição de animal
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $birth_date = $_POST['birth_date'];
    $species = $_POST['species'];
    $breed = $_POST['breed'];

    $vaccination_card = '';
    $photo = '';

    // Upload da carteira de vacinação (somente JPG)
    if (!empty($_FILES['vaccination_card']['name'])) {
        $file_ext = strtolower(pathinfo($_FILES['vaccination_card']['name'], PATHINFO_EXTENSION));
        if ($file_ext === 'jpg' || $file_ext === 'jpeg') {
            $vaccination_card = time() . '_vaccination_card_' . $user_id . '.jpg';
            move_uploaded_file($_FILES['vaccination_card']['tmp_name'], "uploads/$vaccination_card");
        } else {
            echo "Erro: A carteira de vacinação deve ser uma imagem JPG.";
            exit;
        }
    }

    // Upload da foto do animal (somente JPG)
    if (!empty($_FILES['photo']['name'])) {
        $file_ext = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
        if ($file_ext === 'jpg' || $file_ext === 'jpeg') {
            $photo = time() . '_photo_' . $user_id . '.jpg';
            move_uploaded_file($_FILES['photo']['tmp_name'], "uploads/$photo");
        } else {
            echo "Erro: A foto do animal deve ser uma imagem JPG.";
            exit;
        }
    }

    // Insere os dados do novo animal no banco de dados
    try {
        $stmt = $pdo->prepare("INSERT INTO animals (name, birth_date, species, breed, vaccination_card, photo, user_id) VALUES (:name, :birth_date, :species, :breed, :vaccination_card, :photo, :user_id)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':birth_date', $birth_date);
        $stmt->bindParam(':species', $species);
        $stmt->bindParam(':breed', $breed);
        $stmt->bindParam(':vaccination_card', $vaccination_card);
        $stmt->bindParam(':photo', $photo);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();

        // Redireciona para o dashboard após salvar
        header("Location: dashboard.php");
        exit;
    } catch (PDOException $e) {
        echo "Erro ao adicionar animal: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Adicionar Animal</title>
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

        input, select {
            width: 100%;
            padding: 8px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
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
            <h2>Adicionar Animal</h2>
            <form method="POST" enctype="multipart/form-data">
                <label for="name">Nome do Animal</label>
                <input type="text" id="name" name="name" required>

                <label for="birth_date">Data de Nascimento</label>
                <input type="date" id="birth_date" name="birth_date" required>

                <label for="species">Espécie</label>
                <input type="text" id="species" name="species" required>

                <label for="breed">Raça</label>
                <input type="text" id="breed" name="breed" required>

                <!-- Aceitar somente JPG -->
                <label for="vaccination_card">Carteira de Vacinação (Imagem JPG)</label>
                <input type="file" id="vaccination_card" name="vaccination_card" accept=".jpg, .jpeg">

                <label for="photo">Foto do Animal (Imagem JPG)</label>
                <input type="file" id="photo" name="photo" accept=".jpg, .jpeg">

                <div class="button-container">
                    <button type="submit" class="button">Adicionar Animal</button>
                    <button type="button" class="button button-back" onclick="window.location.href='dashboard.php'">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>