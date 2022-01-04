<?php
    session_start();
    ob_start();
    //Importa o conexão.php
    include_once './conexao.php';

    $id = filter_input(INPUT_GET, "usu_id", FILTER_SANITIZE_NUMBER_INT);

    if((!isset($_SESSION['USU_ID']) AND (!isset($_SESSION['USU_NOME'])))) {
        $_SESSION['msg'] = "Necessário realizar login para acessar esta página";

        header("Location: telaLogin.php");
    }
?>

<!DOCTYPE html>
<html lang="pt_BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GestãoBov - Dashboard</title>
</head>
<body>
    <h1>Bem-vindo, <?php echo $_SESSION['USU_NOME'] ?></h1>

    <button onclick="window.location.href = './listarUsuarios.php'">Listar Usuários (apenas teste)</button>

    <button onclick="window.location.href = './listarAnimais.php'">Listar Animais</button>

    <button onclick="window.location.href = './cadastroAnimal.php'">Cadastrar Animais</button>

    <button onclick="window.location.href = './sair.php'">Sair</button><br><br><br>
</body>
</html>