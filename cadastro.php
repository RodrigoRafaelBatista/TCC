<?php
    //Importa o conexão.php
    include_once './conexao.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>GestãoBov - Cadastrar</title>
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

				<form action="" name="cad-usuario" method="POST" class="login100-form validate-form">
					<span class="login100-form-title">
						Cadastrar
					</span>

                    <label>Nome: </label>
                    <input type="text" name="nome" id="nome" placeholder="Insira seu nome completo" 
                    value="<?php
                        // Se o usuário digitou e-mail inválido, mantém a informação no formulário
                        if (isset($dados['nome'])){
                            echo $dados['nome'];
                        }
                    ?>"> <br><br>

                    <label>E-mail: </label>
                    <input type="email" name="email" id="email" placeholder="Insira seu e-mail"
                    value="<?php
                        // Se o usuário digitou e-mail inválido, mantém a informação no formulário
                        if (isset($dados['email'])){
                            echo $dados['email'];
                        }
                    ?>"> <br><br>

                    <label>Senha: </label>
                    <input type="password" name="senha" id="senha" placeholder="Insira sua senha"> <br><br>

                    <label>Confirmação da Senha: </label>
                    <input type="password" name="confSenha" id="confSenha" placeholder="Confirme sua senha"> <br><br>

                    <input class="container-login100-form-btn login100-form-btn" type="submit" value="Cadastrar" name="CadUsuario">

                    

                    <?php
                        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);        // Variável que recebe os dados preenchidos no formulário dentro de um array
                        
                        if(!empty($dados['CadUsuario'])){       // Verifica se a variável dados é diferente de vazio

                            // var_dump($dados);
                            $empty_input = false;       // Variável para saber se o usuário preencheu todos os campos do formulário, inicia como false(não preenchido)
                            $dados = array_map('trim',  $dados);        // Remove os espaços do inicio ou final da String

                            if(in_array("", $dados)){       // Verifica dentro da variável dados que é um array, se existe algum campo que é vazio, já com os espaços removidos
                                $empty_input = true;        // Se houver campos vazios então a variável se torna true e posteriormente o cadastro será recusado.
                                echo "<p style = 'color: red;'> Erro: É necessário preencher todos os campos!</p>";
                            } elseif (!filter_var($dados['email'], FILTER_VALIDATE_EMAIL)){     // Validação se o e-mail preenchido tem caracterísicas de e-mail
                                $empty_input = true;
                                echo "<p style = 'color: red;'> Erro: O e-mail informado é inválido!</p>";
                            }

                            if(!$empty_input){      // Se a variável for false, então todos os campos foram preenchidos corretamente e o cadastro será enviado para o MySQL
                                
                                $query_usuario = "CALL AddUser(:nome, :email, :senha);";        //Variável recebe a query SQL, no caso a procedure de cadastro de usuário
                
                                $cad_usuario = $conn->prepare($query_usuario);                          // Prepara a query para execução
                                $cad_usuario->bindParam(':nome', $dados['nome'], PDO::PARAM_STR);       // Determina o tipo de dado que será enviado para a variável
                                $cad_usuario->bindParam(':email', $dados['email'], PDO::PARAM_STR);     // Determina o tipo de dado que será enviado para a variável
                                $cad_usuario->bindParam(':senha', $dados['senha'], PDO::PARAM_STR);     // Determina o tipo de dado que será enviado para a variável
                                $cad_usuario->execute();                                                // Executa a query (envia para o banco, conforme o arquivo conexao)
                
                                // Verifica se o cadastro foi feito com sucesso e retorna na tela com uma mensagem
                                if($cad_usuario->rowCount()){
                                    echo "<p style = 'color: green;'> Usuário cadastrado com sucesso!</p>";
                                    unset($dados);
                                } else {
                                    echo "<p style = 'color: red;'> Erro: Usuário não cadastrado!</p>";
                                }
                            }
                        }
                    ?>
					
				</form>
                <div class="wrap-login100" data-tilt>

                    <button class="container-login100-form-btn login100-form-btn" onclick="window.location.href = './index.php'">Voltar</button>
                <div>
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