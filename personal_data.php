<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Pet ID - Dados Pessoais</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Dados Pessoais</h1>
        <form action="save_personal_data.php" method="POST">
            <input type="text" name="name" placeholder="Nome" required>
            <input type="text" name="address" placeholder="Endereço" required>
            <input type="tel" name="phone" placeholder="Telefone" required>
            <input type="email" name="email" placeholder="E-mail" required>
            <textarea name="observations" placeholder="Observações"></textarea>
            <button type="submit">Salvar Dados</button>
        </form>
    </div>
</body>
</html>