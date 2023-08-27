<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
</head>
<body>
    <?php
        $nome = $_GET['nome'];
        $email = $_GET['email'];
        echo "<p>Seu dados serão espalhados pela internet!</P>";
        echo "$nome.<br>";
        echo "$email.<br>";
        echo "<p>Obrigado!</p>"
    ?>
</body>
</html>