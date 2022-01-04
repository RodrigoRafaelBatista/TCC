<?php
    session_start();
    ob_start();
    //Importa o conexão.php
    include_once './conexao.php';

    if((!isset($_SESSION['USU_ID']) AND (!isset($_SESSION['USU_NOME'])))) {
        $_SESSION['msg'] = "Necessário realizar login para acessar esta página";

        header("Location: dashboard.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>GestãoBov - Cadastro Animal</title>
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

				<form action="" name="cad-animal" method="POST" class="login100-form validate-form">
					<span class="login100-form-title">
						Cadastrar Novo Animal
					</span>
                    
                    <input class="input100" type="text" name="brinco" id="brinco" maxlength="10" placeholder="Número do brinco" 
                    value="<?php
                        // mantém a informação no formulário
                        if (isset($dados['brinco'])){
                            echo $dados['brinco'];
                        }
                    ?>"> <br><br>

                    <label>Tipo: </label>
                    <select class="input100" name="tipo" id="tipo">
                        <option value="Corte">Corte</option>
                        <option value="Leite">Leite</option>
                    </select> <br><br>

                    <label>Raça: </label>
                    <select class="input100" name="raca" id="raca">
                        <?php
                            $lista_opcoes = $conn->prepare("SELECT * FROM RACA");
                            $lista_opcoes->execute();

                            if($lista_opcoes->rowCount() != 0){ 
                                while($seleciona = $lista_opcoes->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<option value='{$seleciona['RACA_ID']}'>{$seleciona['RACA_ID']} - {$seleciona['RACA_DESCRICAO']}</option>";
                                }
                            }
                        ?>
                    </select> <br><br>

                    <label>Pai: </label>
                    <select class="input100" name="pai" id="pai">
                        
                        <?php
                            $lista_opcoes = $conn->prepare("SELECT * FROM BOVINO WHERE BOV_USU = :bov_usu");                
                            $lista_opcoes->bindParam(':bov_usu', $_SESSION['USU_ID']);
                            $lista_opcoes->execute();
                            //$vazio = '';       // Talvez de pra tirar esta variavel - usando no campo value como variavel nula
                            echo "<option value=''> Não informado</option>";
                            if($lista_opcoes->rowCount() != 0){ 
                                while($seleciona = $lista_opcoes->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<option value='{$seleciona['BOV_ID']}'> Brinco nº {$seleciona['BOV_BRINCO']}</option>";
                                }
                            }
                        ?>
                    </select> <br><br>

                    <label>Mãe: </label>
                    <select  class="input100" name="mae" id="mae">
                        
                        <?php
                            $lista_opcoes = $conn->prepare("SELECT * FROM BOVINO WHERE BOV_USU = :bov_usu");                
                            $lista_opcoes->bindParam(':bov_usu', $_SESSION['USU_ID']);
                            $lista_opcoes->execute();
                            //$vazio = 'null';        // Talvez de pra tirar esta variavel - usando no campo value como variavel nula
                            echo "<option value=''> Não informado</option>";
                            if($lista_opcoes->rowCount() != 0){ 
                                while($seleciona = $lista_opcoes->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<option value='{$seleciona['BOV_ID']}'> Brinco nº {$seleciona['BOV_BRINCO']}</option>";
                                }
                            }
                        ?>
                    </select> <br><br>

                    
                    <input class="input100" type="text" name="litro" id="litro" placeholder="Produção em litros leite" 
                    value="<?php
                        // mantém a informação no formulário
                        if (isset($dados['leite'])){
                            echo $dados['leite'];
                        }
                    ?>"> <br><br>

                    <input class="input100" type="text" name="arroba" id="arroba" placeholder="Produção em arroba" 
                    value="<?php
                        // mantém a informação no formulário
                        if (isset($dados['arroba'])){
                            echo $dados['arroba'];
                        }
                    ?>"> <br><br>

                    <label>Data de Nascimento: </label>
                    <input type="date" name="nascimento" id="nascimento" placeholder="Insira a data de nascimento do animal"><br><br>

                    <label>Data de Aquisição: </label>
                    <input type="date" name="aquisicao" id="aquisicao" placeholder="Insira a data de aquisição do animal"> <br><br>

                    <label>Data de Venda:</label>
                    <input type="date" name="venda" id="venda" placeholder="Insira a data de venda do animal"> <br><br>


                    
                    
                    <input class="container-login100-form-btn login100-form-btn" type="submit" value="Cadastrar" name="CadAnimal">

                    

                    <?php
                    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);        // Variável que recebe os dados preenchidos no formulário dentro de um array
                    
                    if(!empty($dados['CadAnimal'])){       // Verifica se a variável dados é diferente de vazio

                        // var_dump($dados);
                        $empty_input = false;       
                        $dados = array_map('trim',  $dados);      

                        if(!$empty_input){      // Se a variável for false, então todos os campos foram preenchidos corretamente e o cadastro será enviado para o MySQL
                            $repete = false;
                            $query_brincos = "SELECT BOV_BRINCO FROM BOVINO WHERE BOV_USU = :bov_usu AND BOV_STA = 1";
                            $brincos = $conn->prepare($query_brincos);
                            $brincos->bindParam(':bov_usu', $_SESSION['USU_ID'], PDO::PARAM_INT);
                            $brincos->execute();

                            while ($row_usuario = $brincos->fetch(PDO::FETCH_ASSOC)) {
                                extract($row_usuario);

                                if ($dados['brinco'] == $BOV_BRINCO) {
                                    echo "<p style = 'color: red;'> O número de Brinco informado já existe!!</p>";
                                    $repete = true;
                                } 
                            }
                            
                            if ($repete == false) {
                                
                                if (empty($dados['mae']) AND empty($dados['pai'])) {
                                    cadastroAnimal($conn, $dados);      
                                }
                                else if($dados['mae'] == $dados['pai']) {
                                    echo "<p style = 'color: red;'> O Campo Pai e Mãe tem o mesmo animal selecionado!</p>";
                                } else {
                                    cadastroAnimal($conn, $dados);                                
                                }
                            }
                        }
                    }

                    function cadastroAnimal($conn, $dados) {
                                $query_usuario = "CALL AddBov(1, :bov_usu, :brinco, :tipo, :raca, :pai, :mae, :litro, :arroba, :nascimento, :aquisicao, :venda);";        //Variável recebe a query SQL, no caso a procedure de cadastro de animal
                
                                $cad_animal = $conn->prepare($query_usuario);                           // Prepara a query para execução
                                $cad_animal->bindParam(':bov_usu', $_SESSION['USU_ID'], PDO::PARAM_INT);        // Determina o tipo de dado que será enviado para a variável     
                                $cad_animal->bindParam(':brinco', $dados['brinco'], PDO::PARAM_STR);            // Determina o tipo de dado que será enviado para a variável
                                $cad_animal->bindParam(':tipo', $dados['tipo'], PDO::PARAM_STR);                // Determina o tipo de dado que será enviado para a variável
                                $cad_animal->bindParam(':raca', $dados['raca'], PDO::PARAM_STR);                // Determina o tipo de dado que será enviado para a variável
                                if(empty($dados['pai'])) {
                                    $cad_animal->bindParam(':pai', $dados['pai'], PDO::PARAM_NULL);
                                } else {
                                    $cad_animal->bindParam(':pai', $dados['pai'], PDO::PARAM_STR);
                                }
                                if(empty($dados['mae'])) {
                                    $cad_animal->bindParam(':mae', $dados['mae'], PDO::PARAM_NULL);
                                } else {
                                    $cad_animal->bindParam(':mae', $dados['mae'], PDO::PARAM_STR);
                                }
                                if(empty($dados['litro'])) {
                                    $cad_animal->bindParam(':litro', $dados['litro'], PDO::PARAM_NULL);
                                } else {
                                    $cad_animal->bindParam(':litro', $dados['litro'], PDO::PARAM_INT);
                                }
                                if(empty($dados['arroba'])) {
                                    $cad_animal->bindParam(':arroba', $dados['arroba'], PDO::PARAM_NULL);
                                } else {
                                    $cad_animal->bindParam(':arroba', $dados['arroba'], PDO::PARAM_INT);
                                }
                                if(empty($dados['nascimento'])) {
                                    $cad_animal->bindParam(':nascimento', $dados['nascimento'], PDO::PARAM_NULL);
                                } else {
                                    $cad_animal->bindParam(':nascimento', $dados['nascimento'], PDO::PARAM_STR);
                                }
                                if(empty($dados['aquisicao'])) {
                                    $cad_animal->bindParam(':aquisicao', $dados['aquisicao'], PDO::PARAM_NULL);
                                } else {
                                    $cad_animal->bindParam(':aquisicao', $dados['aquisicao'], PDO::PARAM_STR);
                                }
                                if(empty($dados['venda'])) {
                                    $cad_animal->bindParam(':venda', $dados['venda'], PDO::PARAM_NULL);
                                } else {
                                    $cad_animal->bindParam(':venda', $dados['venda'], PDO::PARAM_STR);
                                }
                                $cad_animal->execute();                                        // Executa a query (envia para o banco, conforme o arquivo conexao)
    
                               
                                
                                // Verifica se o cadastro foi feito com sucesso e retorna na tela com uma mensagem
                                if($cad_animal->rowCount()){
                                    echo "<p style = 'color: green;'> Animal cadastrado com sucesso!</p>";
                                    unset($dados);
                                } else {
                                    echo "<p style = 'color: red;'> Erro: Animal não cadastrado!</p>";
                                }
                    }
                
                    ?>

                </form>				
               
                <div class="wrap-login100" data-tilt>
                    <button class="container-login100-form-btn login100-form-btn" onclick="window.location.href = './dashboard.php'">Voltar</button>
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