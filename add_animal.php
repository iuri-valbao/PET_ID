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
        <form action="save_animal.php" method="POST" enctype="multipart/form-data">
            <input type="text" name="name" placeholder="Nome" required>
            <input type="date" name="birth_date" placeholder="Data de Nascimento" required>
            <input type="text" name="type" placeholder="Tipo/espécie" required>
            <input type="text" name="breed" placeholder="Raça" required>
            <input type="file" name="vaccination_card" placeholder="Carteira de Vacinação" accept=".pdf">
            <input type="file" name="photo" placeholder="Foto" accept=".jpg,.jpeg,.png">
            <button type="submit">Cadastrar</button>
        </form>
    </div>
</body>
</html>