<?php		
	session_start();
    ob_start();
    //Importa o conexão.php
    include_once './conexao.php';
    require_once "fpdf184/fpdf.php";

    if ((!isset($_SESSION['USU_ID']) and (!isset($_SESSION['USU_NOME'])))) {
        $_SESSION['msg'] = "Necessário realizar login para acessar esta página";
    
        header("Location: dashboard.php");
    }


  /*   $pdf = new FPDF();
    $pdf->AddPage();

    $arquivo = "Relatorio Geral.pdf";


    $tipo_pdf = "D";

    $pdf->Output($arquivo, $tipo_pdf); */

    ?>
	<!DOCTYPE html>
<html lang="en">
<head>
	<title>GestãoBov - Relatório Geral</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="Table_Fixed_Header/images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="Table_Fixed_Header/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="Table_Fixed_Header/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="Table_Fixed_Header/vendor/animate/animate.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="Table_Fixed_Header/vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="Table_Fixed_Header/vendor/perfect-scrollbar/perfect-scrollbar.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="Table_Fixed_Header/css/util.css">
	<link rel="stylesheet" type="text/css" href="Table_Fixed_Header/css/main.css">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-table100">
			<div class="wrap-table100">
				<div class="table100 ver1 m-b-110">
					<div class="table100-head">
						<table>
							<thead>
								<tr class="row100 head">
									<th class="cell100 column5">ID Bovino</th>
									<th class="cell100 column5">Brinco</th>
									<th class="cell100 column5">Tipo</th>
									<th class="cell100 column5">Raça</th>
									<th class="cell100 column1">Vacinas</th>
									<th class="cell100 column5">Brinco Pai</th>
									<th class="cell100 column5">Brinco Mãe</th>
								</tr>
							</thead>
						</table>
					</div>

					<div class="table100-body js-pscroll">
						<table>
							<tbody>
								
								<?php
									$array = array();
									$posicao = 0;

									//echo "<b>Produtor:</b> {$_SESSION['USU_NOME']} <br>";
									$query_usuarios  = "SELECT BOV_ID FROM BOVINO WHERE BOV_USU = :bov_usu";
									$result_usuarios = $conn->prepare($query_usuarios);
									$result_usuarios->bindParam(':bov_usu', $_SESSION['USU_ID']);
									$result_usuarios->execute();
									if (($result_usuarios) and ($result_usuarios->rowCount() != 0)) {
										
										while ($row_usuario = $result_usuarios->fetch(PDO::FETCH_ASSOC)) {
											//var_dump($row_usuario);
											extract($row_usuario);
											$array[$posicao] = $BOV_ID;

											$query_usuarios2  = "SELECT
																B.BOV_ID, B.BOV_BRINCO, B.BOV_TIPO,
																R.RACA_DESCRICAO AS RACA,
																GROUP_CONCAT(CV.CADVAC_DESCRICAO) AS VACINAS,
																PAI.BOV_BRINCO	AS	BOV_BRINCO_PAI,
																MAE.BOV_BRINCO	AS	BOV_BRINCO_MAE,
																U.USU_NOME		AS NOME
															FROM BOVINO B
															LEFT JOIN RACA				R	ON	R.RACA_ID			=	B.BOV_RACA
															LEFT JOIN VACINACAO			V	ON	V.VAC_BOV_ID		=	B.BOV_ID
															LEFT JOIN CADASTROVACINA	CV	ON	CV.CADVAC_ID		=	V.CADVAC_ID
															LEFT JOIN BOVINO 			PAI	ON	PAI.BOV_ID			=	B.BOV_PAI
															LEFT JOIN BOVINO 			MAE	ON	MAE.BOV_ID			=	B.BOV_MAE
															LEFT JOIN USUARIO			U	ON U.USU_ID				=	B.BOV_USU
															WHERE B.BOV_ID = $array[$posicao]";
											$result_usuarios2 = $conn->prepare($query_usuarios2);
											$result_usuarios2->execute();
											
											if (($result_usuarios2) and ($result_usuarios2->rowCount() != 0)) {
												
												while ($row_usuario2 = $result_usuarios2->fetch(PDO::FETCH_ASSOC)) {
													//var_dump($row_usuario);
													extract($row_usuario2);
													echo "
													<tr class='row100 body'>
														<td class='cell100 column5'>$BOV_ID</td>
														<td class='cell100 column5'>$BOV_BRINCO</td>
														<td class='cell100 column5'>$BOV_TIPO</td>
														<td class='cell100 column5'>$RACA</td>
														<td class='cell100 column1'>$VACINAS</td>
														<td class='cell100 column5'>$BOV_BRINCO_PAI</td>
														<td class='cell100 column5'>$BOV_BRINCO_MAE</td>
													</tr>
													";

													/* echo "<b>ID do Bovino:</b> $BOV_ID <br>";            
													echo "<b>Brinco do Bovino:</b> $BOV_BRINCO <br>";            
													echo "<b>Tipo:</b> $BOV_TIPO <br>";            
													echo "<b>Raça:</b> $RACA <br>";            
													echo "<b>Vacinas Feitas:</b> $VACINAS <br>";            
													echo "<b>Brinco do Pai:</b> $BOV_BRINCO_PAI <br>";            
													echo "<b>Brinco da Mãe:</b> $BOV_BRINCO_MAE <br>";
													echo "<hr>";   */                   
												}
													
											} else {
												echo "<p style = 'color: red;'> Erro: Não existem animais cadastrados!</p>";
											}
											$posicao++;                            
										}

									} else {
										echo "<p style = 'color: red;'> Erro: Não existem animais cadastrados!</p>";
									}
									
									?>
								
							</tbody>
						</table>
					</div>
				</div>
				
			</div>
		</div>
	</div>


<!--===============================================================================================-->	
	<script src="Table_Fixed_Header/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="Table_Fixed_Header/vendor/bootstrap/js/popper.js"></script>
	<script src="Table_Fixed_Header/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="Table_Fixed_Header/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="Table_Fixed_Header/vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
	<script>
		$('.js-pscroll').each(function(){
			var ps = new PerfectScrollbar(this);

			$(window).on('resize', function(){
				ps.update();
			})
		});
			
		
	</script>
<!--===============================================================================================-->
	<script src="Table_Fixed_Header/js/main.js"></script>

</body>
</html>