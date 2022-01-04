<?php
session_start();
ob_start();
//Importa o conexão.php
include_once './conexao.php';

if ((!isset($_SESSION['USU_ID']) and (!isset($_SESSION['USU_NOME'])))) {
    $_SESSION['msg'] = "Necessário realizar login para acessar esta página";

    header("Location: dashboard.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>GestãoBov - Listar Animais</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="images/icons/favicon.ico" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <!--===============================================================================================-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

</head>

<body>

    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <div class="login100-pic js-tilt" data-tilt>
                    <img src="images/img-01.png" alt="IMG">
                </div>
                <h1>Seus animais cadastrados</h1>

                <?php

                try {

                

                //Receber número da página
                $pagina_atual = filter_input(INPUT_GET, "page", FILTER_SANITIZE_NUMBER_INT);
                //Se for vazio o número da pagina, atribui para a página 1
                $pagina = (!empty($pagina_atual)) ? $pagina_atual : 1;

                // Seta a quantidade máxima de registros por página
                $limite_resultado = 5;

                // Calcula o inicio da visualização 
                $inicio = ($limite_resultado * $pagina) - $limite_resultado;

                //var_dump($pagina);
                echo "<div align='left'>";
                $query_usuarios  = "SELECT * FROM BOVINO WHERE BOV_USU = :bov_usu AND BOV_STA = 1 ORDER BY BOV_ID DESC LIMIT $inicio, $limite_resultado";
                $result_usuarios = $conn->prepare($query_usuarios);
                $result_usuarios->bindParam(':bov_usu', $_SESSION['USU_ID']);
                $result_usuarios->execute();
                if (($result_usuarios) and ($result_usuarios->rowCount() != 0)) {
                    while ($row_usuario = $result_usuarios->fetch(PDO::FETCH_ASSOC)) {
                        //var_dump($row_usuario);
                        extract($row_usuario);
                        //echo "Bovino ID:  $BOV_ID <br>" . PHP_EOL;
                        //echo "Dono do Bovino:  $BOV_USU <br>" . PHP_EOL;
                        echo "Brinco:  $BOV_BRINCO <br>" . PHP_EOL;
                        echo "Tipo:  $BOV_TIPO <br>" . PHP_EOL;
                        //echo "Raça: $BOV_RACA <br>" . PHP_EOL;
                        //echo "ID do Pai: $BOV_PAI <br>" . PHP_EOL;
                        //echo "ID da Mãe: $BOV_MAE <br>" . PHP_EOL;
                        //echo "Produção Litro: $BOV_PRODUCLITRO <br>" . PHP_EOL;
                        //echo "Produção Arroba: $BOV_PRODUCARROBA <br>" . PHP_EOL;
                        //echo "Data de Nascimento: $BOV_DT_NASC <br>" . PHP_EOL;
                        //echo "Data de Aquisição: $BOV_DT_AQUIS <br>" . PHP_EOL;
                        //echo "Data de Venda: $BOV_DT_VENDA <br>" . PHP_EOL;

                        echo "<a class='btn btn-outline-success' href='visualizarAnimal.php?bov_id=$BOV_ID'> Relatório </a>" . PHP_EOL;
                        echo "<a class='btn btn-outline-success' href='editarAnimal.php?bov_id=$BOV_ID' > Editar </a>" . PHP_EOL;
                        echo "<a class='btn btn-outline-success' href='apagarAnimal.php?bov_id=$BOV_ID'> Apagar </a>" . PHP_EOL;
                        echo "<a class='btn btn-outline-success' href='manejoAnimal.php?bov_id=$BOV_ID'> Manejo </a>" . PHP_EOL;
                        echo "<hr>" . PHP_EOL;
                    }

                    echo "</div>";

                    echo "<div class='wrap-login100'>";
                    echo "<div align='left'>";

                    // Contar a quantidade de registros no banco
                    $query_quantidade_registros = "SELECT COUNT(BOV_ID) AS num_result FROM BOVINO WHERE BOV_USU = :bov_usu";
                    $result_quantidade_registros = $conn->prepare($query_quantidade_registros);                    
                    $result_quantidade_registros->bindParam(':bov_usu', $_SESSION['USU_ID'], PDO::FETCH_ASSOC);
                    $result_quantidade_registros->execute();
                    $row_quantidade_registros = $result_quantidade_registros->fetch(PDO::FETCH_ASSOC);

                    // Quantidade de páginas, arredondando com o ceil
                    $quantidade_pagina = (ceil($row_quantidade_registros['num_result'] / $limite_resultado)-2);

                    // Defini a quantidade de páginas antes e depois da página atual no rodapé
                    $maximo_link = 1;
                    
                    if ($quantidade_pagina > 1) {

                        echo "<a class='btn btn-outline-info' href='listarAnimais.php?page=1'> Primeira </a>";
            
                        // Exibe as páginas anteriores
                        for($pagina_anterior = $pagina - $maximo_link; $pagina_anterior <= $pagina - 1; $pagina_anterior++) {
                            if($pagina_anterior >= 1) {
                                echo "<a class='btn btn-outline-info' href='listarAnimais.php?page=$pagina_anterior'> $pagina_anterior </a>";
                            }
                        }
            
                        // Página atual (no meio)
                        echo "<a class='btn btn-outline-secondary'> $pagina </a>";
            
                        // Exibe as páginas posteriores
                        for($proxima_pagina = $pagina + 1; $proxima_pagina <= $pagina + $maximo_link; $proxima_pagina++) {
                            if($proxima_pagina <= $quantidade_pagina) {
                                echo "<a class='btn btn-outline-info' href='listarAnimais.php?page=$proxima_pagina'> $proxima_pagina </A>";
                            }
                        }
            
                        echo "<a class='btn btn-outline-info' href='listarAnimais.php?page=$quantidade_pagina'> Última </a>";
                    }

                    echo "</div>";
                    echo "</div>";


                } else {
                    echo "<p style = 'color: red;'> Erro: Não existem animais cadastrados!";
                }

                } catch (Exception $e) {
                        echo "Erro: $e";
                }
                ?>
                <!-- <button onclick="window.location.href = './dashboard.php'">Voltar</button> -->

            </div>
            

            <div class="container-login100-form-btn">
                <button class="login100-form-btn" onclick="window.location.href = './dashboard.php'">Voltar</button>
            </div>	
        </div>

    </div>
    </div>




    <!--===============================================================================================-->
    <script src="vendor/jquery/jquery-3.2.1.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/bootstrap/js/popper.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/select2/select2.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/tilt/tilt.jquery.min.js"></script>
    <script>
        $('.js-tilt').tilt({
            scale: 1.1
        })
    </script>
    <!--===============================================================================================-->
    <script src="js/main.js"></script>

</body>

</html>