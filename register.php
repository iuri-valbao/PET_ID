<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Pet ID - Criar Conta</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Criar Conta</h1>
        <form action="create_account.php" method="POST">
            <input type="email" name="email" placeholder="E-mail" required>
            <input type="password" name="password" placeholder="Crie uma senha" required>
            <button type="submit">Criar Conta</button>
        </form>
    </div>
</body>
</html>