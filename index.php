<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Pet ID - Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Pet ID</h1>
        <div class="form-container">
            <form action="login.php" method="POST">
                <input type="text" name="username" placeholder="Usuário" required>
                <input type="password" name="password" placeholder="Senha" required>
                <button type="submit">Login</button>
            </form>
            <a href="register.php">Criar nova conta</a>
        </div>
    </div>
</body>
</html>