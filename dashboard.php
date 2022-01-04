<?php
ini_set("display_errors", E_ALL);

    session_start();
    ob_start();
    //Importa o conexão.php
    include_once './conexao.php';

    $id = filter_input(INPUT_GET, "usu_id", FILTER_SANITIZE_NUMBER_INT);

    if((!isset($_SESSION['USU_ID']) AND (!isset($_SESSION['USU_NOME'])))) {
        $_SESSION['msg'] = "Necessário realizar login para acessar esta página";

        header("Location: index.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>GestãoBov - Dashboard</title>
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
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="images/img-01.png" alt="IMG">
				</div>

				<div class="login100-form validate-form">
					<span class="login100-form-title">
                        <h1>Bem-vindo, <?php echo $_SESSION['USU_NOME'] ?></h1>
					</span>			
					
					<!-- <div class="container-login100-form-btn">
                        <button class="login100-form-btn" onclick="window.location.href = './listarUsuarios.php'">Listar Usuários (apenas teste)</button>
					</div> -->

                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn" onclick="window.location.href = './listarAnimais.php'">Listar Animais</button>
					</div>

                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn" onclick="window.location.href = './cadastroAnimal.php'">Cadastrar Animais</button>
                    </div>

					<div class="container-login100-form-btn">
                        <button class="login100-form-btn" onclick="window.location.href = './tabela3.php'">Relatório Geral</button>
                    </div>

                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn" onclick="window.location.href = './sair.php'">Sair</button>
                    </div>					
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