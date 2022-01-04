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
<html lang="en">
<head>
	<title>GestãoBov - Visualizar Animal</title>
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

				<form class="login100-form validate-form">
					<span class="login100-form-title">
						Mais detalhes do animal
					</span>

                    <span class="login100-form-title">
						Dados Gerais
					</span>

                    <?php
                    //$query_usuario = "SELECT * FROM BOVINO WHERE BOV_ID = $id AND BOV_USU = :bov_usu LIMIT 1";
                    $query_usuario = "  SELECT b.*, raca_descricao, pai.bov_brinco as bov_brinco_pai, mae.bov_brinco as bov_brinco_mae FROM BOVINO b
                                        left join raca on b.bov_raca = raca.RACA_ID
                                        left join bovino pai on b.bov_pai = pai.bov_id
                                        left join bovino mae on b.bov_mae = mae.bov_id
                                        WHERE b.BOV_ID = $id AND b.BOV_USU = :bov_usu LIMIT 1;";
                    $result_usuario = $conn->prepare($query_usuario);
                    $result_usuario->bindParam(':bov_usu', $_SESSION['USU_ID']);
                    $result_usuario->execute();

                    if(($result_usuario) AND ($result_usuario->rowCount() != 0)) {
                        $row_usuario = $result_usuario->fetch(PDO::FETCH_ASSOC);
                        //var_dump($row_usuario);

                        extract($row_usuario);

                        echo "<b>Bovino ID:</b>  $BOV_ID <br>";
                        //echo "<b>Dono do Bovino:</b>  $BOV_USU <br>";
                        echo "<b>Brinco:</b>  $BOV_BRINCO <br>";
                        echo "<b>Tipo:</b>  $BOV_TIPO <br>";
                        echo "<b>Raça:</b> $raca_descricao <br>";
                        if ($bov_brinco_pai != NULL) {
                            echo "<b>Brinco do Pai:</b> $bov_brinco_pai <br>";
                        } else {
                            echo "<b>Brinco do Pai:</b> Não informado <br>";
                        }

                        if ($bov_brinco_mae != NULL) {
                            echo "<b>Brinco da Mãe:</b> $bov_brinco_mae <br>";                            
                        } else {
                            echo "<b>Brinco da Mãe:</b> Não informado <br>";                            
                        }
                        echo "<b>Produção Litro:</b> $BOV_PRODUCLITRO <br>";
                        echo "<b>Produção Arroba: </b> $BOV_PRODUCARROBA <br>";
                        if($BOV_DT_NASC != NULL) {
                            $BOV_DT_NASC = strtotime($BOV_DT_NASC);
                            $BOV_DT_NASC = date("d/m/Y", $BOV_DT_NASC);
                            echo "<b>Data de Nascimento:</b> $BOV_DT_NASC <br>";
                        }
                        if($BOV_DT_AQUIS != NULL) {
                            $BOV_DT_AQUIS = strtotime($BOV_DT_AQUIS);
                            $BOV_DT_AQUIS = date("d/m/Y", $BOV_DT_AQUIS);
                            echo "<b>Data de Aquisição:</b> $BOV_DT_AQUIS <br>";
                        }
                        if($BOV_DT_VENDA != NULL) {
                            $BOV_DT_VENDA = strtotime($BOV_DT_VENDA);
                            $BOV_DT_VENDA = date("d/m/Y", $BOV_DT_VENDA);
                            echo "<b>Data de Venda:</b> $BOV_DT_VENDA <br>";
                        }
                        if($BOV_DT_DESMAME != null) {
                            echo "<b>Data do Desmame: </b> $BOV_DT_DESMAME <br>";
                        }
                        echo "<hr>";
                    }

                    ?>

                    <a class="login100-form-title" id="AcaoRegistroVacina" style="cursor:pointer;">      
						Ver Vacinas Feitas
                    </a>

                    <div id="RegistroVacina" style="display:none;">
                        <?php
                        //$query_usuario = "SELECT * FROM BOVINO WHERE BOV_ID = $id AND BOV_USU = :bov_usu LIMIT 1";
                        $query_usuario = "  SELECT VACINACAO.CADVAC_ID, VACINACAO.VAC_DATA, CADASTROVACINA.CADVAC_DESCRICAO FROM VACINACAO
                                            LEFT JOIN CADASTROVACINA ON VACINACAO.CADVAC_ID = CADASTROVACINA.CADVAC_ID
                                            WHERE VAC_BOV_ID = $id";
                        $result_usuario = $conn->prepare($query_usuario);
                        $result_usuario->execute();
                        $registros = $result_usuario->rowCount();

                        if(($result_usuario) AND ($result_usuario->rowCount() != 0)) {
                            while ($row_usuario = $result_usuario->fetch(PDO::FETCH_ASSOC)) {
                            
                            //var_dump($row_usuario);

                            extract($row_usuario);

                            echo "<b>Vacina:</b>  $CADVAC_DESCRICAO <br>";
                            echo "<b>Data Aplicada:</b>  $VAC_DATA <br>";
                            //echo "$registros";
                            echo "<hr>";
                            } 
                        }else {
                            echo "Não foram cadastradas vacinas para o animal selecionado";
                        }

                        ?>
                    </div>

                    
                    <a class="login100-form-title" id="AcaoRegistroDoenca" style="cursor:pointer;">
						Ver Doenças Registradas
                    </a>
                    
                    <div id="RegistroDoenca" style="display:none;">
                    
                        <?php
                        //$query_usuario = "SELECT * FROM BOVINO WHERE BOV_ID = $id AND BOV_USU = :bov_usu LIMIT 1";
                        $query_usuario = "  SELECT REGISTRADOENCA.REGDOENCA_ID, REGISTRADOENCA.REGDOENCA_DATA, REGISTRADOENCA.REGDOENCA_MEDIC, CADASTRODOENCA.CADDOENCA_DESC
                                            FROM REGISTRADOENCA
                                            LEFT JOIN CADASTRODOENCA ON REGISTRADOENCA.CADDOE_ID = CADASTRODOENCA.CADDOENCA_ID
                                            WHERE REG_BOV_ID = $id;";
                        $result_usuario = $conn->prepare($query_usuario);
                        $result_usuario->execute();
                        $registros = $result_usuario->rowCount();

                        if(($result_usuario) AND ($result_usuario->rowCount() != 0)) {
                            while ($row_usuario = $result_usuario->fetch(PDO::FETCH_ASSOC)) {
                            
                            //var_dump($row_usuario);

                            extract($row_usuario);

                            echo "<b>Doença:</b>  $CADDOENCA_DESC <br>";
                            echo "<b>Data Aplicada:</b>  $REGDOENCA_DATA <br>";
                            echo "<b>Medicação usada:</b>  $REGDOENCA_MEDIC <br>";
                            //echo "$registros";
                            echo "<hr>";
                            }
                        } else {
                            echo "Não foram cadastradas doenças para o animal selecionado";
                        }

                        ?>
                    </div>

                    <a class="login100-form-title" id="AcaoRegistroProducao" style="cursor:pointer;">
						Ver Produção
                    </a>

                    <div id="RegistroProducao" style="display:none;">
                    
                        <?php
                        //$query_usuario = "SELECT * FROM BOVINO WHERE BOV_ID = $id AND BOV_USU = :bov_usu LIMIT 1";
                        $query_usuario = "  SELECT PRODUCAO.* FROM PRODUCAO
                                            LEFT JOIN BOVINO ON PRODUCAO.PRODUC_BOV_ID = BOVINO.BOV_ID
                                            WHERE PRODUC_BOV_ID = $id;";
                        $result_usuario = $conn->prepare($query_usuario);
                        $result_usuario->execute();
                        $registros = $result_usuario->rowCount();
                        $count = 1;
                        if(($result_usuario) AND ($result_usuario->rowCount() != 0)) {
                            while ($row_usuario = $result_usuario->fetch(PDO::FETCH_ASSOC)) {
                            
                            //var_dump($row_usuario);

                            extract($row_usuario);
                            echo "{$count}º Produção cadastrada<br>";
                            echo "<b>Produção:</b>  $PRODUC_LITROS <br>";
                            echo "<b>Data Cadastrada:</b>  $PRODUC_DATA <br>";
                            //echo "$registros";
                            echo "<hr>";
                            $count++;
                            }
                        } else {
                            echo "Não foram cadastradas produduções para o animal selecionado";
                        }

                        ?>
                    </div>

                    <a class="login100-form-title" id="AcaoRegistroInseminacao" style="cursor:pointer;">
						Ver Inseminação
                    </a>

                    <div id="RegistroInseminacao" style="display:none;">
                    
                        <?php
                        //$query_usuario = "SELECT * FROM BOVINO WHERE BOV_ID = $id AND BOV_USU = :bov_usu LIMIT 1";
                        $query_usuario = "  SELECT INSEMINACAO.*, DATE_ADD(INSEM_DATA, INTERVAL +308 DAY) AS maisCio,
                                                            DATE_ADD(INSEM_DATA, INTERVAL +258 DAY) AS menosCio FROM INSEMINACAO
                                            LEFT JOIN BOVINO ON INSEMINACAO.INSEM_BOV_ID = BOVINO.BOV_ID
                                            WHERE INSEM_BOV_ID = $id;";
                        $result_usuario = $conn->prepare($query_usuario);
                        $result_usuario->execute();
                        $registros = $result_usuario->rowCount();
                        $count = 1;
                        if(($result_usuario) AND ($result_usuario->rowCount() != 0)) {
                            while ($row_usuario = $result_usuario->fetch(PDO::FETCH_ASSOC)) {
                            
                            //var_dump($row_usuario);
                            
                            extract($row_usuario);

                            $INSEM_DATA = strtotime($INSEM_DATA);
                            $INSEM_DATA = date("d/m/Y", $INSEM_DATA);

                            $menosCio = strtotime($menosCio);
                            $menosCio = date("d/m/Y", $menosCio);

                            $maisCio = strtotime($maisCio);
                            $maisCio = date("d/m/Y", $maisCio);

                            echo "{$count}º Inseminação cadastrada<br>";
                            echo "<b>Descrição Inseminação:</b>  $INSEM_DESCRICAO <br>";
                            echo "<b>Data Inclusão e CIO:</b>  $INSEM_DATA <br>";
                            echo "<b>Data Prévia<br> Nascimento mínima:</b>  $menosCio <br>";
                            echo "<b>Data Prévia<br> Nascimento máxima:</b>  $maisCio <br>";
                            //echo "$registros";
                            echo "<hr>";
                            $count++;
                            }
                        } else {
                            echo "Não foram cadastradas inseminações para o animal selecionado";
                        }

                        ?>
                    </div>

				</form>
                <div class="wrap-login100" data-tilt>
                    <button class="container-login100-form-btn login100-form-btn" onclick="window.location.href = './listarAnimais.php'">Voltar</button>
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
<!--===============================================================================================-->
	<script src="js/main.js"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})

        $(document).on("click", "#AcaoRegistroDoenca", mostrarRegistroDoenca);
        $(document).on("click", "#AcaoRegistroVacina", mostrarRegistroVacina);
        $(document).on("click", "#AcaoRegistroProducao", mostrarRegistroProducao);
        $(document).on("click", "#AcaoRegistroInseminacao", mostrarRegistroInseminacao);

        function mostrarRegistroDoenca(){
            $("#RegistroDoenca").toggle();
        }
        function mostrarRegistroVacina(){
            $("#RegistroVacina").toggle();
        }
        function mostrarRegistroProducao(){
            $("#RegistroProducao").toggle();
        }
        function mostrarRegistroInseminacao(){
            $("#RegistroInseminacao").toggle();
        }

    </script>
</body>
</html>