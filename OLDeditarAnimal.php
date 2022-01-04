<?php
    session_start();
    ob_start();
    //Importa o conexão.php
    include_once './conexao.php';

    $id = filter_input(INPUT_GET, "bov_id", FILTER_SANITIZE_NUMBER_INT);

    //var_dump($id);

    if(empty($id)) {
        $_SESSION['msg'] = "<p style='color: red;'> Animal não encontrado! </p>";
        header("Location: index.php");
        exit();
    }

    $query_usuario = "SELECT * FROM BOVINO WHERE BOV_ID = $id LIMIT 1";
    $result_usuario = $conn->prepare($query_usuario);
    $result_usuario->execute();

    if(($result_usuario) AND ($result_usuario->rowCount() != 0)) {
        $row_usuario = $result_usuario->fetch(PDO::FETCH_ASSOC);
        //var_dump($row_usuario);
    } else {
        $_SESSION['msg'] = "<p style='color: red;'> Animal não encontrado! </p>";
        header("Location: index.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GestãoBov - Editar</title>
</head>
<body>
    <h1>Editar </h1>

    <?php
        //Receber dados formulario
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        //var_dump($dados);

        //Vefica se clicou no botao
        if(!empty($dados['EditAnimal'])) {
            $empty_input = false;
            $dados = array_map('trim', $dados);
            if(in_array("", $dados)) {
                $empty_input = true;
                echo "Necessário preencher todos os campos!";
            }

            if(!$empty_input) {
                $query_up_usuario = "UPDATE BOVINO SET  BOV_BRINCO       = :brinco,
                                                        BOV_TIPO         = :tipo,
                                                        BOV_RACA         = :raca,
                                                        BOV_PAI          = :pai,
                                                        BOV_MAE          = :mae,
                                                        BOV_PRODUCLITRO  = :litro,
                                                        BOV_PRODUCARROBA = :arroba,
                                                        BOV_DT_NASC      = :nascimento,
                                                        BOV_DT_AQUIS     = :aquisicao,
                                                        BOV_DT_VENDA     = :venda
                                                    WHERE BOV_ID = :id";
                $edit_usuario = $conn->prepare($query_up_usuario);
                $edit_usuario->bindParam(':brinco', $dados['brinco'], PDO::PARAM_STR);
                $edit_usuario->bindParam(':tipo', $dados['tipo'], PDO::PARAM_STR);
                $edit_usuario->bindParam(':id', $id, PDO::PARAM_INT);
                $edit_usuario->BindParam(':raca', $dados['raca'], PDO::PARAM_INT);
                $edit_usuario->BindParam(':pai', $dados['pai'], PDO::PARAM_NULL);
                $edit_usuario->BindParam(':mae', $dados['mae'], PDO::PARAM_NULL);
                $edit_usuario->BindParam(':litro', $dados['litro'], PDO::PARAM_INT);
                $edit_usuario->BindParam(':arroba', $dados['arroba'], PDO::PARAM_INT);
                $edit_usuario->BindParam(':nascimento', $dados['nascimento'], PDO::PARAM_STR);
                $edit_usuario->BindParam(':aquisicao', $dados['aquisicao'], PDO::PARAM_STR);
                $edit_usuario->BindParam(':venda', $dados['venda'], PDO::PARAM_STR);

                if($edit_usuario->execute()) {
                    $_SESSION['msg'] =  "Animal editado com sucesso!";
                    header ("Location: listarAnimais.php");
                } else {
                    $_SESSION['msg'] =  "Animal não editado!";
                }
            }
        }
    ?>

    <form action="" method="POST" id="edit-animal">
        <label> Brinco: </label>
        <input type="text" name="brinco" id="brinco" placeholder="Brinco" value="<?php if(isset($dados['brinco'])) {echo $dados['brinco'];} else if(isset($row_usuario['BOV_BRINCO'])) {echo $row_usuario['BOV_BRINCO'];} ?>" required> <br><br>

        <label> Tipo: </label>
        <input type="text" name="tipo" id="tipo" placeholder="Tipo" value="<?php if(isset($dados['tipo'])) {echo $dados['tipo'];} else if(isset($row_usuario['BOV_TIPO'])) {echo $row_usuario['BOV_TIPO'];} ?>" required> <br><br>

        <label> Raça: </label>
        <input type="text" name="raca" id="raca" placeholder="Raça" value="<?php if(isset($dados['raca'])) {echo $dados['raca'];} else if(isset($row_usuario['BOV_RACA'])) {echo $row_usuario['BOV_RACA'];} ?>" required> <br><br>

        <label> ID do Pai: </label>
        <input type="text" name="pai" id="pai" placeholder="Pai" value="<?php if(isset($dados['pai'])) {echo $dados['pai'];} else if(isset($row_usuario['BOV_PAI'])) {echo $row_usuario['BOV_PAI'];} ?>" required> <br><br>

        <label> ID da Mãe: </label>
        <input type="text" name="mae" id="mae" placeholder="Mãe" value="<?php if(isset($dados['mae'])) {echo $dados['mae'];} else if(isset($row_usuario['BOV_MAE'])) {echo $row_usuario['BOV_MAE'];} ?>" required> <br><br>
        
        <label> Produção Litro: </label>
        <input type="text" name="litro" id="litro" placeholder="Litro" value="<?php if(isset($dados['litro'])) {echo $dados['litro'];} else if(isset($row_usuario['BOV_PRODUCLITRO'])) {echo $row_usuario['BOV_PRODUCLITRO'];} ?>" required> <br><br>

        <label> Produção Arroba: </label>
        <input type="text" name="arroba" id="arroba" placeholder="Arroba" value="<?php if(isset($dados['arroba'])) {echo $dados['arroba'];} else if(isset($row_usuario['BOV_PRODUCARROBA'])) {echo $row_usuario['BOV_PRODUCARROBA'];} ?>" required> <br><br>

        <label> Data de Nascimento: </label>
        <input type="text" name="nascimento" id="nascimento" placeholder="Nascimento" value="<?php if(isset($dados['nascimento'])) {echo $dados['nascimento'];} else if(isset($row_usuario['BOV_DT_NASC'])) {echo $row_usuario['BOV_DT_NASC'];} ?>" required> <br><br>

        <label> Data de Aquisição: </label>
        <input type="text" name="aquisicao" id="aquisicao" placeholder="Aquisição" value="<?php if(isset($dados['aquisicao'])) {echo $dados['aquisicao'];} else if(isset($row_usuario['BOV_DT_AQUIS'])) {echo $row_usuario['BOV_DT_AQUIS'];} ?>" required> <br><br>

        <label> Data de Venda: </label>
        <input type="text" name="venda" id="venda" placeholder="Venda" value="<?php if(isset($dados['venda'])) {echo $dados['venda'];} else if(isset($row_usuario['BOV_DT_VENDA'])) {echo $row_usuario['BOV_DT_VENDA'];} ?>" required> <br><br>

        <input type="submit" value="Salvar" name="EditAnimal">

    </form>
    
</body>
</html>