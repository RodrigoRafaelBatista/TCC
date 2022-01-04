<?php
    session_start();
    ob_start();
    //Importa o conexão.php
    include_once './conexao.php';

    $id = filter_input(INPUT_GET, "usu_id", FILTER_SANITIZE_NUMBER_INT);

    //var_dump($id);

    if(empty($id)) {
        $_SESSION['msg'] = "<p style='color: red;'> Usuário não encontrado! </p>";
        header("Location: index.php");
        exit();
    }

    $query_usuario = "SELECT * FROM USUARIO WHERE USU_ID = $id LIMIT 1";
    $result_usuario = $conn->prepare($query_usuario);
    $result_usuario->execute();

    if(($result_usuario) AND ($result_usuario->rowCount() != 0)) {
        $row_usuario = $result_usuario->fetch(PDO::FETCH_ASSOC);
        //var_dump($row_usuario);
    } else {
        $_SESSION['msg'] = "<p style='color: red;'> Usuário não encontrado! </p>";
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

        var_dump($dados);

        //Vefica se clicou no botao
        if(!empty($dados['EditUsuario'])) {
            $empty_input = false;
            $dados = array_map('trim', $dados);
            if(in_array("", $dados)) {
                $empty_input = true;
                echo "Necessário preencher todos os campos!";
            }

            if(!$empty_input) {
                $query_up_usuario = "UPDATE USUARIO SET USU_NOME = :nome, USU_EMAIL=:email WHERE USU_ID = :id";
                $edit_usuario = $conn->prepare($query_up_usuario);
                $edit_usuario->bindParam(':nome', $dados['nome'], PDO::PARAM_STR);
                $edit_usuario->bindParam(':email', $dados['email'], PDO::PARAM_STR);
                $edit_usuario->bindParam(':id', $id, PDO::PARAM_INT);

                if($edit_usuario->execute()) {
                    $_SESSION['msg'] =  "Usuário editado com sucesso!";
                    header ("Location: listarUsuarios.php");
                } else {
                    $_SESSION['msg'] =  "Usuário não editado!";
                }
            }
        }
    ?>

    <form action="" method="POST" id="edit-usuario">
        <label> Nome: </label>
        <input type="text" name="nome" id="nome" placeholder="Nome Completo" value="<?php if(isset($dados['nome'])) {echo $dados['nome'];} else if(isset($row_usuario['USU_NOME'])) {echo $row_usuario['USU_NOME'];} ?>" required> <br><br>

        <label> Email: </label>
        <input type="email" name="email" id="email" placeholder="Novo e-mail" value="<?php if(isset($dados['email'])) {echo $dados['email'];} else if(isset($row_usuario['USU_EMAIL'])) {echo $row_usuario['USU_EMAIL'];} ?>" required> <br><br>

        <input type="submit" value="Salvar" name="EditUsuario">

    </form>
    
</body>
</html>