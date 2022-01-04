<?php
    session_start();
    ob_start();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GestãoBov</title>
</head>
<body>

    <?php
        if(isset($SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
    ?>
    <h1>Bem Vindo ao GestãoBov</h1>

    <button onclick="window.location.href = './cadastro.php'">Cadastre-se</button>

    

    <button onclick="window.location.href = './telaLogin.php'">Login</button>
</body>
</html>