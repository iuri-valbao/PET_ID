<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site em PHP</title>
    <style>
        h2 {
            color: blue;
        }
        body {
            background-color: yellow;
        }
    </style>
</head>
<body>
    <h1>Testando PHP</h1>
    <?php
        echo "<h2>Olá Mundo!</h2><br>";    
    ?>
    <?php
        $n1 = 2;
        $n2 = 5;
        $soma = $n1 + $n2;
        echo "A soma vale $soma.";
    ?>
</body>
</html>