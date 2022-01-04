<?php
    session_start();
    ob_start();
    //Importa o conexão.php
    include_once './conexao.php';

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
    <title>GestãoBov - Listar Animais</title>
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

        $query_usuarios  = "SELECT * FROM BOVINO WHERE BOV_USU = :bov_usu AND BOV_STA = 1 ORDER BY BOV_ID DESC LIMIT $inicio, $limite_resultado";
        $result_usuarios = $conn->prepare($query_usuarios);
        $result_usuarios->bindParam(':bov_usu', $_SESSION['USU_ID']);    
        $result_usuarios->execute();

        if(($result_usuarios) AND ($result_usuarios->rowCount() != 0)) {
             while($row_usuario = $result_usuarios->fetch(PDO::FETCH_ASSOC)){
                 //var_dump($row_usuario);
                 extract($row_usuario);
                 echo "Bovino ID:  $BOV_ID <br>";
                 echo "Dono do Bovino:  $BOV_USU <br>";
                 echo "Brinco:  $BOV_BRINCO <br>";
                 echo "Tipo:  $BOV_TIPO ";
                 echo "Raça: $BOV_RACA <br>";
                 echo "ID do Pai: $BOV_PAI <br>";
                 echo "ID da Mãe: $BOV_MAE <br>";
                 echo "Produção Litro: $BOV_PRODUCLITRO <br>";
                 echo "Produção Arroba: $BOV_PRODUCARROBA <br>";
                 echo "Data de Nascimento: $BOV_DT_NASC <br>";
                 echo "Data de Aquisição: $BOV_DT_AQUIS <br>";
                 echo "Data de Venda: $BOV_DT_VENDA <br>";

                 echo "<a href='visualizarAnimal.php?bov_id=$BOV_ID'> Visualizar </a> <br>";
                 echo "<a href='editarAnimal.php?bov_id=$BOV_ID'> Editar </a> <br>";
                 echo "<a href='apagarAnimal.php?bov_id=$BOV_ID'> Apagar </a> <br>";
                 echo "<hr>";
             }

             // Contar a quantidade de registros no banco
             $query_quantidade_registros = "SELECT COUNT(BOV_ID) AS num_result FROM BOVINO";
             $result_quantidade_registros = $conn->prepare($query_quantidade_registros);
             $result_quantidade_registros->execute();
             $row_quantidade_registros = $result_quantidade_registros->fetch(PDO::FETCH_ASSOC);

             // Quantidade de páginas, arredondando com o ceil
             $quantidade_pagina = (ceil($row_quantidade_registros['num_result'] / $limite_resultado)-1);

            // Defini a quantidade de páginas antes e depois da página atual no rodapé
             $maximo_link = 2;
             
             if ($quantidade_pagina != 0) {

                echo "<a href='OLDlistarAnimais.php?page=1'> Primeira </a>";
    
                // Exibe as páginas anteriores
                for($pagina_anterior = $pagina - $maximo_link; $pagina_anterior <= $pagina - 1; $pagina_anterior++) {
                    if($pagina_anterior >= 1) {
                        echo "<a href='OLDlistarAnimais.php?page=$pagina_anterior'> $pagina_anterior </a>";
                    }
                }
    
                // Página atual (no meio)
                echo "<a > $pagina </a>";
    
                // Exibe as páginas posteriores
                for($proxima_pagina = $pagina + 1; $proxima_pagina <= $pagina + $maximo_link; $proxima_pagina++) {
                    if($proxima_pagina <= $quantidade_pagina) {
                        echo "<a href='OLDlistarAnimais.php?page=$proxima_pagina'> $proxima_pagina </A>";
                    }
                }
    
                echo "<a href='OLDlistarAnimais.php?page=$quantidade_pagina'> Última </a>";
             }


        } else {
            echo "<p style = 'color: red;'> Erro: Não existem animais cadastrados!</p>";
        }
    ?>
    <br><button onclick="window.location.href = './dashboard.php'">Voltar</button>
</body>
</html>