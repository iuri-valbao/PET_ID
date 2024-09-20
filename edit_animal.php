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
        echo "Animal não encontrado ou você não tem permissão para editá-lo.";
        exit;
    }
} catch (PDOException $e) {
    echo "Erro ao buscar dados do animal: " . $e->getMessage();
    exit;
}

// Atualiza os dados do animal no banco de dados
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $birth_date = $_POST['birth_date'];
    $species = $_POST['species'];
    $breed = $_POST['breed'];

    // Verifica e faz upload da carteira de vacinação e da foto, se forem alteradas
    $vaccination_card = $animal['vaccination_card'];
    $photo = $animal['photo'];

    if (!empty($_FILES['vaccination_card']['name'])) {
        $vaccination_card = time() . '_' . $_FILES['vaccination_card']['name'];
        move_uploaded_file($_FILES['vaccination_card']['tmp_name'], "uploads/$vaccination_card");
    }

    if (!empty($_FILES['photo']['name'])) {
        $photo = time() . '_' . $_FILES['photo']['name'];
        move_uploaded_file($_FILES['photo']['tmp_name'], "uploads/$photo");
    }

    try {
        $stmt = $pdo->prepare("UPDATE animals SET name = :name, birth_date = :birth_date, species = :species, breed = :breed, vaccination_card = :vaccination_card, photo = :photo WHERE id = :animal_id AND user_id = :user_id");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':birth_date', $birth_date);
        $stmt->bindParam(':species', $species);
        $stmt->bindParam(':breed', $breed);
        $stmt->bindParam(':vaccination_card', $vaccination_card);
        $stmt->bindParam(':photo', $photo);
        $stmt->bindParam(':animal_id', $animal_id);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();

        // Redireciona para a página de visualização do animal após salvar
        header("Location: view_animal.php?animal_id=$animal_id");
        exit;
    } catch (PDOException $e) {
        echo "Erro ao atualizar dados do animal: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Animal</title>
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
            <h2>Editar Animal: <?php echo htmlspecialchars($animal['name']); ?></h2>
            <form method="POST" enctype="multipart/form-data">
                <label for="name">Nome do Animal</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($animal['name']); ?>" required>

                <label for="birth_date">Data de Nascimento</label>
                <input type="date" id="birth_date" name="birth_date" value="<?php echo htmlspecialchars($animal['birth_date']); ?>" required>

                <label for="species">Espécie</label>
                <input type="text" id="species" name="species" value="<?php echo htmlspecialchars($animal['species']); ?>" required>

                <label for="breed">Raça</label>
                <input type="text" id="breed" name="breed" value="<?php echo htmlspecialchars($animal['breed']); ?>" required>

                <label for="vaccination_card">Carteira de Vacinação (PDF)</label>
                <input type="file" id="vaccination_card" name="vaccination_card" accept=".pdf">

                <label for="photo">Foto do Animal (Imagem)</label>
                <input type="file" id="photo" name="photo" accept="image/*">

                <div class="button-container">
                    <button type="submit" class="button">Salvar Alterações</button>
                    <button type="button" class="button button-back" onclick="window.location.href='view_animal.php?animal_id=<?php echo $animal_id; ?>'">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>