<?php
$qr_code_path = isset($_GET['qr_code']) ? $_GET['qr_code'] : '';

if (!$qr_code_path) {
    echo "QR Code não encontrado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Imprimir QR Code</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: white;
        }
        img {
            max-width: 100%;
            max-height: 100%;
        }
    </style>
    <script>
        // Script para acionar a impressão automaticamente
        window.onload = function() {
            window.print();
        }
    </script>
</head>
<body>
    <img src="<?php echo htmlspecialchars($qr_code_path); ?>" alt="QR Code">
</body>
</html>