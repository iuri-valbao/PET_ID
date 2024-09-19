<?php
require 'db_connection.php';

// Verifica se o ID do usuário está na URL ou na sessão
if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
} else {
    echo "ID de usuário não fornecido!";
    exit;
}

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $observations = $_POST['observations'];

    try {
        // Atualizar os dados pessoais do usuário
        $stmt = $pdo->prepare("UPDATE users SET name = :name, address = :address, phone = :phone, observations = :observations WHERE id = :user_id");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':observations', $observations);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();

        echo "Dados pessoais atualizados com sucesso!";
        header("Location: dashboard.php");
        exit;
    } catch (PDOException $e) {
        echo "Erro ao atualizar dados: " . $e->getMessage();
    }
} else {
    // Caso o formulário não tenha sido enviado, busca os dados atuais do usuário
    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :user_id");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$user) {
            echo "Usuário não encontrado!";
            exit;
        }
    } catch (PDOException $e) {
        echo "Erro ao buscar dados: " . $e->getMessage();
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Pet ID - Editar Dados Pessoais</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Editar Dados Pessoais</h1>
        <form action="personal_data.php?user_id=<?php echo $user_id; ?>" method="POST">
            <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" placeholder="Nome" required>
            <input type="text" name="address" value="<?php echo htmlspecialchars($user['address']); ?>" placeholder="Endereço" required>
            <input type="tel" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" placeholder="Telefone" required>
            <textarea name="observations" placeholder="Observações"><?php echo htmlspecialchars($user['observations']); ?></textarea>
            <button type="submit">Salvar Dados</button>
        </form>
    </div>
</body>
</html>