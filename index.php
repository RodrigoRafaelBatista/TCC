<?php
ini_set("display_errors", E_ALL);

    session_start();
    ob_start();
    //Importa o conexão.php
    include_once './conexao.php';

	if((isset($_SESSION['USU_ID']) AND (isset($_SESSION['USU_NOME'])))) {
        header("Location: dashboard.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>GestãoBov</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
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
</head>
<body>

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
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="images/img-01.png" alt="IMG">
				</div>

				<form method="POST" class="login100-form validate-form">
					<span class="login100-form-title">
						Bem-vindo ao GestãoBov!
					</span>

					<div class="wrap-input100 validate-input" data-validate = "É necessário informar e-mail válido">
						<input class="input100" type="text" name="email" id="email" placeholder="Email">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Senha requerida">
						<input class="input100" type="password" name="senha" id="senha" placeholder="Senha">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
					
					<div class="container-login100-form-btn">
						
                        
                        <input type="submit" value="Login" name="SendLogin" class="login100-form-btn">
					</div>
	
				</form>

                <div class="login100-form validate-form text-center p-t-136">
						<a class="txt2" href='./cadastro.php'>
							 Cadastre-se aqui
							<i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
						</a>
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
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>