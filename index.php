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
        echo "<h2>Olá Mundo!</h2><br/>";    
    ?>
    <?php
        $n1 = $_GET["a"];
        $n2 = $_GET["b"];
        $s = $n1 + $n2;
        $m = $n1 * $n2;
        echo "A soma vale de $n1 e $n2 é igual a $s.<br/>";
        echo "A multiplicação de $n1 por $n2 é igual a $m";
    ?>
</body>
</html>