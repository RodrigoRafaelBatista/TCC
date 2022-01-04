<?php
    session_start();
    ob_start();
    //Importa o conexão.php
    include_once './conexao.php';

    $id = filter_input(INPUT_GET, "bov_id", FILTER_SANITIZE_NUMBER_INT);

    //var_dump($id);

    if(empty($id)) {
        $_SESSION['msg'] = "<p style='color: red;'> Usuário não encontrado! </p>";
        header("Location: dashboard.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GestãoBov - Visualizar Animal</title>
</head>
<body>
    <h1>Visualizar</h1>

    <?php
        $query_usuario = "SELECT * FROM BOVINO WHERE BOV_ID = $id AND BOV_USU = :bov_usu LIMIT 1";
        $result_usuario = $conn->prepare($query_usuario);
        $result_usuario->bindParam(':bov_usu', $_SESSION['USU_ID']);
        $result_usuario->execute();

        if(($result_usuario) AND ($result_usuario->rowCount() != 0)) {
            $row_usuario = $result_usuario->fetch(PDO::FETCH_ASSOC);
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
            echo "<hr>";
        } else {
            $_SESSION['msg'] = "<p style='color: red;'> Animal não encontrado! </p>";

            header("Location: dashboard.php");
        }
    ?>
    <br><button onclick="window.location.href = './listarAnimais.php'">Voltar</button>
    
</body>
</html>