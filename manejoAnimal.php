<?php
    session_start();
    ob_start();
    //Importa o conexão.php
    include_once './conexao.php';

    if ((!isset($_SESSION['USU_ID']) and (!isset($_SESSION['USU_NOME'])))) {
        $_SESSION['msg'] = "Necessário realizar login para acessar esta página";
    
        header("Location: dashboard.php");
    }

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
<html lang="en">
<head>
	<title>GestãoBov - Manejo Animal</title>
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

				<form class="login100-form validate-form" action="" method="POST" name="cad-manejo">
					<span class="login100-form-title">
						Manejo de Animal
					</span>
                        <center>
                            <input type="checkbox" id="vacinacao" name="vacinacao" value="vacinacao" onchange="mostrarVacina()"> <label for="vacinacao"> Vacinação </label>
                            <input type="checkbox" id="doenca" name="doenca" value="doenca" onchange="mostrarDoenca()"> <label for="doenca"> Doença </label>
                            <input type="checkbox" id="producao" name="producao" value="producao" onchange="mostrarProducao()"> <label for="producao"> Produção </label> <br>
                            <input type="checkbox" id="inseminacao" name="inseminacao" value="inseminacao" onchange="mostrarInseminacao()"> <label for="inseminacao"> Inseminação </label>
                            <input type="checkbox" id="desmame" name="desmame" value="desmame" onchange="mostrarDesmame()"> <label for="desmame"> Desmame </label>
                            <!-- <input type="checkbox" id="cria" name="cria" value="cria" onchange="mostrarCria()"> <label for="cria"> Cria </label>  --> 
                        </center>
                        <div id="exibe_vacinacao" style="display:none">
                            <label>Vacina:</label>
                            <select  class="input100" name="vacinacaoField" id="vacinacaoField">                            
                                <?php
                                    $lista_opcoes = $conn->prepare("SELECT * FROM CADASTROVACINA");
                                    $lista_opcoes->execute();
                                    $vazio = 'null';        // Talvez de pra tirar esta variavel
                                    echo "<option value='{$vazio}'> Não informado</option>";
                                    if($lista_opcoes->rowCount() != 0){ 
                                        while($seleciona = $lista_opcoes->fetch(PDO::FETCH_ASSOC)) {
                                            echo "<option value='{$seleciona['CADVAC_ID']}'> {$seleciona['CADVAC_DESCRICAO']}</option>";
                                        }
                                    }
                                ?>
                            </select>
                            <label>Data da Vacinação:</label>
                            <input type="date" name="dataVacinacaoField" id="dataVacinacaoField">
                            <hr>
                        </div>

                        <div id="exibe_doenca" style="display:none">
                            <label>Doença:</label>
                            <select  class="input100" name="doencaField" id="doencaField">                            
                                <?php
                                    $lista_opcoes = $conn->prepare("SELECT * FROM CADASTRODOENCA");
                                    $lista_opcoes->execute();      
                                    echo "<option value=''> Não informado</option>";
                                    if($lista_opcoes->rowCount() != 0){ 
                                        while($seleciona = $lista_opcoes->fetch(PDO::FETCH_ASSOC)) {
                                            echo "<option value='{$seleciona['CADDOENCA_ID']}'> {$seleciona['CADDOENCA_DESC']}</option>";
                                        }
                                    }
                                ?>
                            </select>
                            <label>Data da Doença:</label>
                            <input type="date" name="dataDoencaField" id="dataDoencaField">

                            <label>Medicamentos:</label>
                            <input type="text" name="medicamentoDoencaField" id="medicamentoDoencaField" placeholder="Descreva aqui os medicamentos usados">
                            <hr>
                        </div>

                        <div id="exibe_producao" style="display:none">
                            <label>Produção:</label>
                            <input type="text" name="producaoField" id="producaoField" placeholder="Insira a Produção de leite">
                            <hr>
                        </div>

                        <div id="exibe_inseminacao" style="display:none">
                            <label>Inseminação:</label>
                            <input type="text" name="inseminacaoField" id="inseminacaoField" placeholder="Insira raça ou informações">
                            <label>Data da Inseminação:</label>
                            <input type="date" name="dataInseminacaoField" id="dataInseminacaoField">
                            <hr>
                        </div>

                        <div id="exibe_desmame" style="display:none">
                            <label>Desmame em:</label>
                            <input type="date" name="desmameField" id="desmameField" placeholder="Insira o desmame">
                            <hr>
                        </div>

                        <!-- <div id="exibe_cria" style="display:none">
                            <label>Cria:</label>
                            <input type="text" name="criaField" id="criaField" placeholder="Insira a cria">
                            <hr>
                        </div> -->

                        <div id="exibe_salvar" style="display: none;">
                            <input class="container-login100-form-btn login100-form-btn" type="submit" value="Salvar" name="CadManejo"> 
                        </div>

                        <?php
                    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);        // Variável que recebe os dados preenchidos no formulário dentro de um array
                    
                    if(!empty($dados['CadManejo'])){       // Verifica se a variável dados é diferente de vazio

                        // var_dump($dados);
                        $empty_input = false;       // Variável para saber se o usuário preencheu todos os campos do formulário, inicia como false(não preenchido)
                        $dados = array_map('trim',  $dados);        // Remove os espaços do inicio ou final da String

                        /* if(in_array("", $dados)){       // Verifica dentro da variável dados que é um array, se existe algum campo que é vazio, já com os espaços removidos
                            $empty_input = true;        // Se houver campos vazios então a variável se torna true e posteriormente o cadastro será recusado.
                            echo "<p style = 'color: red;'> Erro: É necessário preencher todos os campos!</p>";
                        }  */
                        
                        /* elseif (!filter_var($dados['email'], FILTER_VALIDATE_EMAIL)){     // Validação se o e-mail preenchido tem caracterísicas de e-mail
                            $empty_input = true;
                            echo "<p style = 'color: red;'> Erro: O e-mail informado é inválido!</p>";
                        } */

                        if(!$empty_input){      // Se a variável for false, então todos os campos foram preenchidos corretamente e o cadastro será enviado para o MySQL
                            $conn->beginTransaction();

                            if(isset($dados['vacinacao'])){

                                $query_usuario = "INSERT INTO VACINACAO (CADVAC_ID, VAC_BOV_ID, VAC_DATA, VAC_DATA_CAD) VALUES (:vacinacaoField, :bov_id, :dataVacinacaoField, Now());"; //Variável recebe a query SQL, no caso a procedure de cadastro de animal
                
                                $cad_animal = $conn->prepare($query_usuario);                           // Prepara a query para execução
                                $cad_animal->bindParam(':vacinacaoField', $dados['vacinacaoField'], PDO::PARAM_STR);            // Determina o tipo de dado que será enviado para a variável
                                $cad_animal->bindParam(':dataVacinacaoField', $dados['dataVacinacaoField'], PDO::PARAM_STR);                // Determina o tipo de dado que será enviado para a variável                            
                                $cad_animal->bindParam(':bov_id', $id, PDO::PARAM_INT);                // Determina o tipo de dado que será enviado para a variável                            
                                $cad_animal->execute(); // Executa a query (envia para o banco, conforme o arquivo conexao)

                                // Verifica se o cadastro foi feito com sucesso e retorna na tela com uma mensagem
                                if($cad_animal->rowCount()){
                                    echo "<p style = 'color: green;'> Vacina cadastrada com sucesso!</p>";
                                    //unset($dados);
                                } else {
                                    echo "<p style = 'color: red;'> Erro: Vacina não cadastrada!</p>";
                                }
                            
                             }

                             if(isset($dados['doenca'])){
                                
                                $query_usuario = "INSERT INTO REGISTRADOENCA (CADDOE_ID, REG_BOV_ID, REGDOENCA_DATA, REGDOENCA_DATA_CAD, REGDOENCA_MEDIC) VALUES (:doencaField, :bov_id, :dataDoencaField, Now(), :medicamentoDoencaField);"; //Variável recebe a query SQL, no caso a procedure de cadastro de animal
                
                                $cad_animal = $conn->prepare($query_usuario);                           // Prepara a query para execução
                                $cad_animal->bindParam(':doencaField', $dados['doencaField'], PDO::PARAM_INT);            // Determina o tipo de dado que será enviado para a variável                          
                                $cad_animal->bindParam(':medicamentoDoencaField', $dados['medicamentoDoencaField'], PDO::PARAM_STR);            // Determina o tipo de dado que será enviado para a variável                          
                                $cad_animal->bindParam(':dataDoencaField', $dados['dataDoencaField'], PDO::PARAM_STR);            // Determina o tipo de dado que será enviado para a variável                          
                                $cad_animal->bindParam(':bov_id', $id, PDO::PARAM_INT);                // Determina o tipo de dado que será enviado para a variável                            
                                $cad_animal->execute(); // Executa a query (envia para o banco, conforme o arquivo conexao)

                                // Verifica se o cadastro foi feito com sucesso e retorna na tela com uma mensagem
                                if($cad_animal->rowCount()){
                                    echo "<p style = 'color: green;'> Doença cadastrada com sucesso!</p>";
                                    //unset($dados);
                                } else {
                                    echo "<p style = 'color: red;'> Erro: Doença não cadastrada!</p>";
                                }
                            
                             }

                             if(isset($dados['producao'])){

                                $query_usuario = "INSERT INTO PRODUCAO (PRODUC_LITROS, PRODUC_BOV_ID, PRODUC_DATA) VALUES (:producaoField, :bov_id, Now());"; //Variável recebe a query SQL, no caso a procedure de cadastro de animal
                
                                $cad_animal = $conn->prepare($query_usuario);                           // Prepara a query para execução
                                $cad_animal->bindParam(':producaoField', $dados['producaoField'], PDO::PARAM_STR);            // Determina o tipo de dado que será enviado para a variável                            
                                $cad_animal->bindParam(':bov_id', $id, PDO::PARAM_INT);                // Determina o tipo de dado que será enviado para a variável                            
                                $cad_animal->execute(); // Executa a query (envia para o banco, conforme o arquivo conexao)

                                // Verifica se o cadastro foi feito com sucesso e retorna na tela com uma mensagem
                                if($cad_animal->rowCount()){
                                    echo "<p style = 'color: green;'> Produção cadastrada com sucesso!</p>";
                                    //unset($dados);
                                } else {
                                    echo "<p style = 'color: red;'> Erro: Produção não cadastrada!</p>";
                                }
                            
                             }

                             if(isset($dados['inseminacao'])){

                                $query_usuario = "INSERT INTO INSEMINACAO (INSEM_DESCRICAO, INSEM_DATA, INSEM_BOV_ID) VALUES (:inseminacaoField, :dataInseminacaoField, :bov_id);"; //Variável recebe a query SQL, no caso a procedure de cadastro de animal
                
                                $cad_animal = $conn->prepare($query_usuario);                           // Prepara a query para execução
                                $cad_animal->bindParam(':inseminacaoField', $dados['inseminacaoField'], PDO::PARAM_STR);            // Determina o tipo de dado que será enviado para a variável                            
                                $cad_animal->bindParam(':dataInseminacaoField', $dados['dataInseminacaoField'], PDO::PARAM_STR);            // Determina o tipo de dado que será enviado para a variável                            
                            
                                $cad_animal->bindParam(':bov_id', $id, PDO::PARAM_INT);                // Determina o tipo de dado que será enviado para a variável                            
                                $cad_animal->execute(); // Executa a query (envia para o banco, conforme o arquivo conexao)

                                // Verifica se o cadastro foi feito com sucesso e retorna na tela com uma mensagem
                                if($cad_animal->rowCount()){
                                    echo "<p style = 'color: green;'> Inseminação cadastrada com sucesso!</p>";
                                    //unset($dados);
                                } else {
                                    echo "<p style = 'color: red;'> Erro: Inseminação não cadastrada!</p>";
                                }
                            
                             }

                             if(isset($dados['desmame'])){

                                $query_usuario = "UPDATE BOVINO SET BOV_DT_DESMAME = :desmameField WHERE BOV_ID = :bov_id;"; //Variável recebe a query SQL, no caso a procedure de cadastro de animal
                
                                $cad_animal = $conn->prepare($query_usuario);                           // Prepara a query para execução
                                $cad_animal->bindParam(':desmameField', $dados['desmameField'], PDO::PARAM_STR);            // Determina o tipo de dado que será enviado para a variável                                                       
                                $cad_animal->bindParam(':bov_id', $id, PDO::PARAM_INT);                // Determina o tipo de dado que será enviado para a variável                            
                                $cad_animal->execute(); // Executa a query (envia para o banco, conforme o arquivo conexao)

                                // Verifica se o cadastro foi feito com sucesso e retorna na tela com uma mensagem
                                if($cad_animal->rowCount()){
                                    echo "<p style = 'color: green;'> Desmame cadastrada com sucesso!</p>";
                                    //unset($dados);
                                } else {
                                    echo "<p style = 'color: red;'> Erro: Desmame não cadastrada!</p>";
                                }
                            
                             }

                        
                            /* Commit the changes */
                            $conn->commit();

                            if($cad_animal->rowCount()){
                                echo "<p style = 'color: green;'> Itens selecionados cadastrados com sucesso!</p>";
                                unset($dados);
                            } else {
                                echo "<p style = 'color: red;'> Erro: Alguns itens podem não ter sido cadastrados!</p>";
                            }
                            
                            
                            
                        }
                    }
                
                    ?>

					
				</form>

                <div class="wrap-login100" data-tilt>
                    <button class="container-login100-form-btn login100-form-btn" onclick="window.location.href = './listarAnimais.php'">Voltar</button>
                <div>
			</div>
		</div>
	</div>

    <script>
        function mostrarVacina(){
            var checkbox = document.querySelector("#vacinacao");
            //console.log(checkboxVacinacao.checked);
            exibe_vacinacao.style.display=checkbox.checked ? 'block' : 'none';
            exibe_salvar.style.display=checkbox.checked ? 'block' : 'none';
        }
        function mostrarDoenca(){
            var checkbox = document.querySelector("#doenca");
            exibe_doenca.style.display=checkbox.checked ? 'block' : 'none';
            exibe_salvar.style.display=checkbox.checked ? 'block' : 'none';
        }
        function mostrarProducao(){
            var checkbox = document.querySelector("#producao");
            exibe_producao.style.display=checkbox.checked ? 'block' : 'none';
            exibe_salvar.style.display=checkbox.checked ? 'block' : 'none';
        }
        function mostrarInseminacao(){
            var checkbox = document.querySelector("#inseminacao");
            exibe_inseminacao.style.display=checkbox.checked ? 'block' : 'none';
            exibe_salvar.style.display=checkbox.checked ? 'block' : 'none';
        }
        function mostrarDesmame(){
            var checkbox = document.querySelector("#desmame");
            exibe_desmame.style.display=checkbox.checked ? 'block' : 'none';
            exibe_salvar.style.display=checkbox.checked ? 'block' : 'none';
        }
        /* function mostrarCria(){
            var checkbox = document.querySelector("#cria");
            exibe_cria.style.display=checkbox.checked ? 'block' : 'none';
            exibe_salvar.style.display=checkbox.checked ? 'block' : 'none';
        } */

    </script>
	
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