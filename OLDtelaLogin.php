<?php
    session_start();
    ob_start();
    //Importa o conexão.php
    include_once './conexao.php';
?>

<!DOCTYPE html>
<html lang="pt_BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GestãoBov - Login</title>

</head>
<body>
    <h1>Login</h1>

    <?php
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if(!empty($dados['SendLogin'])) {
            //var_dump($dados);

            $query_usuario = "SELECT * FROM USUARIO WHERE USU_EMAIL = :email LIMIT 1";
            $result_usuario = $conn->prepare($query_usuario);
            $result_usuario->bindParam(':email', $dados['email'], PDO::PARAM_STR);
            $result_usuario->execute();

            if(($result_usuario) AND ($result_usuario->rowCount() != 0)) {
                
                $row_usuario = $result_usuario->fetch(PDO::FETCH_ASSOC);
                //var_dump($dados);
               //var_dump($row_usuario);

                if (($dados['senha'] == $row_usuario['USU_SENHA'])) {
                    $_SESSION['USU_ID']     = $row_usuario['USU_ID'];
                    $_SESSION['USU_NOME']   = $row_usuario['USU_NOME'];
                    header("Location: dashboard.php");
                } else {
                    $_SESSION['msg'] = "Erro: Usuário ou senha inválida! ";
                }

            } else { 
                $_SESSION['msg'] = "Erro: Usuário ou senha inválida! ";
            }
        }
    if(isset($_SESSION['msg'])) {
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
    }
    ?>

    <form method="POST" action="">
        <label> E-mail: </label>
        <input type="text" name="email" placeholder="Digite seu e-mail de cadastro"> <br><br>

        <label> Senha: </label>
        <input type="password" name="senha" placeholder="Digite sua senha"> <br><br>

        <input type="submit" value="Acessar" name="SendLogin">
    </form>
    
</body>
</html>