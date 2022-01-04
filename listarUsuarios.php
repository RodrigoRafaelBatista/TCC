<?php
    session_start();
    ob_start();
    //Importa o conexão.php
    include_once './conexao.php';

    if((!isset($_SESSION['USU_ID']) AND (!isset($_SESSION['USU_NOME'])))) {
        $_SESSION['msg'] = "Necessário realizar login para acessar esta página";

        header("Location: index.php");
    } else {
        $_SESSION['msg'] = "Acesso negado!";
        header("Location: index.php");
    }
?>
<!DOCTYPE html>
<html lang="pt_BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GestãoBov - Listar Usuários</title>
</head>
<body>
    <?php

        //Receber número da página
        $pagina_atual = filter_input(INPUT_GET, "page", FILTER_SANITIZE_NUMBER_INT);
        //Se for vazio o número da pagina, atribui para a página 1
        $pagina = (!empty($pagina_atual)) ? $pagina_atual : 1;

        // Seta a quantidade máxima de registros por página
        $limite_resultado = 10;

        // Calcula o inicio da visualização 
        $inicio = ($limite_resultado * $pagina) - $limite_resultado;

        //var_dump($pagina);
        
        $query_usuarios = "SELECT * FROM USUARIO ORDER BY USU_ID DESC LIMIT $inicio, $limite_resultado";
        $result_usuarios = $conn->prepare($query_usuarios);
        $result_usuarios->execute();

        if(($result_usuarios) AND ($result_usuarios->rowCount() != 0)) {
             while($row_usuario = $result_usuarios->fetch(PDO::FETCH_ASSOC)){
                 //var_dump($row_usuario);
                 extract($row_usuario);
                 echo "ID:  $USU_ID <br>";
                 echo "Nome:  $USU_NOME <br>";
                 echo "E-mail:  $USU_EMAIL <br>";
                 echo "Data de Cadastro:  $USU_DTCADASTRO <br><br>";
                 echo "<a href='visualizar.php?usu_id=$USU_ID'> Visualizar </a> <br>";
                 echo "<a href='editarUsuario.php?usu_id=$USU_ID'> Editar </a> <br>";
                 echo "<a href='apagarUsuario.php?usu_id=$USU_ID'> Apagar </a> <br>";
                 echo "<hr>";
             }

             // Contar a quantidade de registros no banco
             $query_quantidade_registros = "SELECT COUNT(USU_ID) AS num_result FROM USUARIO";
             $result_quantidade_registros = $conn->prepare($query_quantidade_registros);
             $result_quantidade_registros->execute();
             $row_quantidade_registros = $result_quantidade_registros->fetch(PDO::FETCH_ASSOC);

             // Quantidade de páginas, arredondando com o ceil
             $quantidade_pagina = ceil($row_quantidade_registros['num_result'] / $limite_resultado);

            // Defini a quantidade de páginas antes e depois da página atual no rodapé
             $maximo_link = 2;

             echo "<a href='listarUsuarios.php?page=1'> Primeira </a>";

             // Exibe as páginas anteriores
             for($pagina_anterior = $pagina - $maximo_link; $pagina_anterior <= $pagina - 1; $pagina_anterior++) {
                 if($pagina_anterior >= 1) {
                     echo "<a href='listarUsuarios.php?page=$pagina_anterior'> $pagina_anterior </a>";
                 }
             }

             // Página atual (no meio)
             echo "<a > $pagina </a>";

             // Exibe as páginas posteriores
             for($proxima_pagina = $pagina + 1; $proxima_pagina <= $pagina + $maximo_link; $proxima_pagina++) {
                 if($proxima_pagina <= $quantidade_pagina) {
                     echo "<a href='listarUsuarios.php?page=$proxima_pagina'> $proxima_pagina </A>";
                 }
             }

             echo "<a href='listarUsuarios.php?page=$quantidade_pagina'> Última </a>";


        } else {
            echo "<p style = 'color: red;'> Erro: Usuário não cadastrado!</p>";
        }
    ?>
    <br><button onclick="window.location.href = './dashboard.php'">Voltar</button>
</body>
</html>