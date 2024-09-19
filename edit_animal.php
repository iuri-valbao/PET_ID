<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

require 'db_connection.php';

$animal_id = $_GET['animal_id'];

// Recupera os dados do animal
try {
    $stmt = $pdo->prepare("SELECT * FROM animals WHERE id = :animal_id AND user_id = :user_id");
    $stmt->bindParam(':animal_id', $animal_id);
    $stmt->bindParam(':user_id', $_SESSION['user_id']);
    $stmt->execute();
    $animal = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$animal) {
        echo "Animal não encontrado!";
        exit;
    }
} catch (PDOException $e) {
    echo "Erro ao buscar dados do animal: " . $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $birth_date = $_POST['birth_date'];
    $type_species = $_POST['type_species'];
    $breed = $_POST['breed'];

    try {
        // Atualiza os dados do animal
        $stmt = $pdo->prepare("UPDATE animals SET name = :name, birth_date = :birth_date, type_species = :type_species, breed = :breed WHERE id = :animal_id AND user_id = :user_id");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':birth_date', $birth_date);
        $stmt->bindParam(':type_species', $type_species);
        $stmt->bindParam(':breed', $breed);
        $stmt->bindParam(':animal_id', $animal_id);
        $stmt->bindParam(':user_id', $_SESSION['user_id']);
        $stmt->execute();

        header("Location: dashboard.php");
        exit;
    } catch (PDOException $e) {
        echo "Erro ao atualizar animal: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Pet ID - Editar Animal</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Editar Animal</h1>
        <form action="edit_animal.php?animal_id=<?php echo $animal_id;