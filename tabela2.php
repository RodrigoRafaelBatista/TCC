<?php		
	session_start();
    ob_start();
    //Importa o conexão.php
    include_once './conexao.php';
    require_once "fpdf184/fpdf.php";

    if ((!isset($_SESSION['USU_ID']) and (!isset($_SESSION['USU_NOME'])))) {
        $_SESSION['msg'] = "Necessário realizar login para acessar esta página";
    
        header("Location: dashboard.php");
    }


  /*   $pdf = new FPDF();
    $pdf->AddPage();

    $arquivo = "Relatorio Geral.pdf";


    $tipo_pdf = "D";

    $pdf->Output($arquivo, $tipo_pdf); */

    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GestãoBov - Relatório</title>
</head>
<body>
    <table class="table">
    <thead>
        <tr>
            <th scope="col">ID Animal</th>
            <th scope="col">Brinco</th>
            <th scope="col">Tipo</th>
            <th scope="col">Raça</th>
            <th scope="col">Vacinas</th>
            <th scope="col">Brinco Pai</th>
            <th scope="col">Brinco Mãe</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $array = array();
            $posicao = 0;

            //echo "<b>Produtor:</b> {$_SESSION['USU_NOME']} <br>";
            $query_usuarios  = "SELECT BOV_ID FROM BOVINO WHERE BOV_USU = :bov_usu";
            $result_usuarios = $conn->prepare($query_usuarios);
            $result_usuarios->bindParam(':bov_usu', $_SESSION['USU_ID']);
            $result_usuarios->execute();
            if (($result_usuarios) and ($result_usuarios->rowCount() != 0)) {
                
                while ($row_usuario = $result_usuarios->fetch(PDO::FETCH_ASSOC)) {
                    //var_dump($row_usuario);
                    extract($row_usuario);
                    $array[$posicao] = $BOV_ID;

                    $query_usuarios2  = "SELECT
                                        B.BOV_ID, B.BOV_BRINCO, B.BOV_TIPO,
                                        R.RACA_DESCRICAO AS RACA,
                                        GROUP_CONCAT(CV.CADVAC_DESCRICAO) AS VACINAS,
                                        PAI.BOV_BRINCO	AS	BOV_BRINCO_PAI,
                                        MAE.BOV_BRINCO	AS	BOV_BRINCO_MAE,
                                        U.USU_NOME		AS NOME
                                    FROM BOVINO B
                                    LEFT JOIN RACA				R	ON	R.RACA_ID			=	B.BOV_RACA
                                    LEFT JOIN VACINACAO			V	ON	V.VAC_BOV_ID		=	B.BOV_ID
                                    LEFT JOIN CADASTROVACINA	CV	ON	CV.CADVAC_ID		=	V.CADVAC_ID
                                    LEFT JOIN BOVINO 			PAI	ON	PAI.BOV_ID			=	B.BOV_PAI
                                    LEFT JOIN BOVINO 			MAE	ON	MAE.BOV_ID			=	B.BOV_MAE
                                    LEFT JOIN USUARIO			U	ON U.USU_ID				=	B.BOV_USU
                                    WHERE B.BOV_ID = $array[$posicao]";
                    $result_usuarios2 = $conn->prepare($query_usuarios2);
                    $result_usuarios2->execute();
                    
                    if (($result_usuarios2) and ($result_usuarios2->rowCount() != 0)) {
                        
                        while ($row_usuario2 = $result_usuarios2->fetch(PDO::FETCH_ASSOC)) {
                            //var_dump($row_usuario);
                            extract($row_usuario2);
                            echo "
                            <tr>
                                <td scope='col'>$BOV_ID</td>
                                <td scope='col'>$BOV_BRINCO</td>
                                <td scope='col'>$BOV_TIPO</td>
                                <td scope='col'>$RACA</td>
                                <td scope='col'>$VACINAS</td>
                                <td scope='col'>$BOV_BRINCO_PAI</td>
                                <td scope='col'>$BOV_BRINCO_MAE</td>
                            </tr>
                            ";

                            /* echo "<b>ID do Bovino:</b> $BOV_ID <br>";            
                            echo "<b>Brinco do Bovino:</b> $BOV_BRINCO <br>";            
                            echo "<b>Tipo:</b> $BOV_TIPO <br>";            
                            echo "<b>Raça:</b> $RACA <br>";            
                            echo "<b>Vacinas Feitas:</b> $VACINAS <br>";            
                            echo "<b>Brinco do Pai:</b> $BOV_BRINCO_PAI <br>";            
                            echo "<b>Brinco da Mãe:</b> $BOV_BRINCO_MAE <br>";
                            echo "<hr>";   */                   
                        }
                            
                    } else {
                        echo "<p style = 'color: red;'> Erro: Não existem animais cadastrados!</p>";
                    }
                    $posicao++;                            
                }

            } else {
                echo "<p style = 'color: red;'> Erro: Não existem animais cadastrados!</p>";
            }

            $query_usuarios22  = "SELECT COUNT(BOV_ID) AS SOMA FROM BOVINO WHERE BOV_USU = :bov_usu";
            $result_usuarios22 = $conn->prepare($query_usuarios22);                    
            $result_usuarios22->bindParam(':bov_usu', $_SESSION['USU_ID']);
            $result_usuarios22->execute();
            
            $row = $result_usuarios22->fetch(PDO::FETCH_ASSOC);

            extract($row);
            echo "
            </tbody>
            </table>
            
                <b>Total de Animais: </b>$SOMA. <br>
                <b>Produtor:</b> $_SESSION[USU_NOME].
            ";
            
        ?>
    </tbody>
    </table>
    
</body>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</html>