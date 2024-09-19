<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

require 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $birth_date = $_POST['birth_date'];
    $type_species = $_POST['type_species'];
    $breed = $_POST['breed'];
    $vaccination_card = $_FILES['vaccination_card']['name'];
    $photo = $_FILES['photo']['name'];
    $user_id = $_SESSION['user_id'];

    // Diretório de upload
    $upload_dir = 'uploads/';

    // Salva os arquivos no diretório
    move_uploaded_file($_FILES['vaccination_card']['tmp_name'], $upload_dir . $vaccination_card);
    move_uploaded_file($_FILES['photo']['tmp_name'], $upload_dir . $photo);

    try {
        // Insere o novo animal no banco de dados
        $stmt = $pdo->prepare("INSERT INTO animals (user_id, name, birth_date, type_species, breed, vaccination_card, photo) 
                               VALUES (:user_id, :name, :birth_date, :type_species, :breed, :vaccination_card, :photo)");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':birth_date', $birth_date);
        $stmt->bindParam(':type_species', $type_species);
        $stmt->bindParam(':breed', $breed);
        $stmt->bindParam(':vaccination_card', $vaccination_card);
        $stmt->bindParam(':photo', $photo);
        $stmt->execute();

        header("Location: dashboard.php");
        exit;
    } catch (PDOException $e) {
        echo "Erro ao cadastrar animal: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Pet ID - Adicionar Animal</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Adicionar Animal</h1>
        <form action="add_animal.php" method="POST" enctype="multipart/form-data">
            <input type="text" name="name" placeholder="Nome do Animal" required>
            <input type="date" name="birth_date" placeholder="Data de Nascimento">
            <input type="text" name="type_species" placeholder="Tipo/Espécie">
            <input type="text" name="breed" placeholder="Raça">
            <label for="vaccination_card">Carteira de Vacinação (PDF/Imagem):</label>
            <input type="file" name="vaccination_card" accept=".pdf, .jpg, .jpeg, .png">
            <label for="photo">Foto do Animal:</label>
            <input type="file" name="photo" accept=".jpg, .jpeg, .png">
            <button type="submit">Cadastrar Animal</button>
        </form>
    </div>
</body>
</html>