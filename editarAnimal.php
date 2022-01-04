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
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GestãoBov - Editar</title>
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
                    

                    <form class="login100-form validate-form" action="" method="POST" id="edit-animal">
                        <label> Brinco: </label>
                        <input type="text" name="brinco" id="brinco" placeholder="Brinco" value="<?php if(isset($dados['brinco'])) {echo $dados['brinco'];} else if(isset($row_usuario['BOV_BRINCO'])) {echo $row_usuario['BOV_BRINCO'];} ?>" required> <br><br>

                        <label> Tipo: </label>
                        <select class="input100" name="tipo" id="tipo">
                            <option value="Corte">Corte</option>
                            <option value="Leite">Leite</option>
                        </select>

                        <label> Raça: </label>
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

                        <label> ID do Pai: </label>
                        <select class="input100" name="pai" id="pai">                        
                            <?php
                                $lista_opcoes = $conn->prepare("SELECT * FROM BOVINO WHERE BOV_USU = :bov_usu");                
                                $lista_opcoes->bindParam(':bov_usu', $_SESSION['USU_ID']);
                                $lista_opcoes->execute();
                                echo "<option value=''> Não informado</option>";
                                if($lista_opcoes->rowCount() != 0){ 
                                    while($seleciona = $lista_opcoes->fetch(PDO::FETCH_ASSOC)) {
                                        echo "<option value='{$seleciona['BOV_ID']}'> Brinco nº {$seleciona['BOV_BRINCO']}</option>";
                                    }
                                }
                            ?>
                        </select> <br><br>

                        <label> ID da Mãe: </label>
                        <select  class="input100" name="mae" id="mae">                            
                            <?php                                
                                $lista_opcoes = $conn->prepare("SELECT * FROM BOVINO WHERE BOV_USU = :bov_usu");                
                                $lista_opcoes->bindParam(':bov_usu', $_SESSION['USU_ID']);
                                $lista_opcoes->execute();
                                echo "<option value=''> Não informado</option>";
                                if($lista_opcoes->rowCount() != 0){ 
                                    while($seleciona = $lista_opcoes->fetch(PDO::FETCH_ASSOC)) {
                                        echo "<option value='{$seleciona['BOV_ID']}'> Brinco nº {$seleciona['BOV_BRINCO']}</option>";
                                    }
                                }
                            ?>
                        </select> <br><br>
                        
                        <label> Produção Litro: </label>
                        <input type="text" name="litro" id="litro" placeholder="Litro" value="<?php if(isset($dados['litro'])) {echo $dados['litro'];} else if(isset($row_usuario['BOV_PRODUCLITRO'])) {echo $row_usuario['BOV_PRODUCLITRO'];} ?>"> <br><br>

                        <label> Produção Arroba: </label>
                        <input type="text" name="arroba" id="arroba" placeholder="Arroba" value="<?php if(isset($dados['arroba'])) {echo $dados['arroba'];} else if(isset($row_usuario['BOV_PRODUCARROBA'])) {echo $row_usuario['BOV_PRODUCARROBA'];} ?>"> <br><br>

                        <label> Data de Nascimento: </label>
                        <input type="date" name="nascimento" id="nascimento" placeholder="Nascimento" value="<?php if(isset($dados['nascimento'])) {echo $dados['nascimento'];} else if(isset($row_usuario['BOV_DT_NASC'])) {echo $row_usuario['BOV_DT_NASC'];} ?>"> <br><br>

                        <label> Data de Aquisição: </label>
                        <input type="date" name="aquisicao" id="aquisicao" placeholder="Aquisição" value="<?php if(isset($dados['aquisicao'])) {echo $dados['aquisicao'];} else if(isset($row_usuario['BOV_DT_AQUIS'])) {echo $row_usuario['BOV_DT_AQUIS'];} ?>"> <br><br>

                        <label> Data de Venda: </label>
                        <input type="date" name="venda" id="venda" placeholder="Venda" value="<?php if(isset($dados['venda'])) {echo $dados['venda'];} else if(isset($row_usuario['BOV_DT_VENDA'])) {echo $row_usuario['BOV_DT_VENDA'];} ?>"> <br><br>

                        <input class="container-login100-form-btn login100-form-btn" type="submit" value="Salvar" name="EditAnimal"> 
                        
                        
                    </form>

                    <div class="wrap-login100" data-tilt>
                        <button class="container-login100-form-btn login100-form-btn" onclick="window.location.href = './listarAnimais.php'">Voltar</button>
                    <div>

                    <?php
                        //Receber dados formulario
                        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
                        //Vefica se clicou no botao
                        if(!empty($dados['EditAnimal'])) {
                            $empty_input = false;
                            $dados = array_map('trim', $dados);
                            
                            if(!$empty_input) {

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
                                        
                                        editaAnimal($conn, $dados, $id);      
                                        
                                    }
                                    else if($dados['mae'] == $dados['pai']) {
                                        echo "<p style = 'color: red;'> O Campo Pai e Mãe tem o mesmo animal selecionado!</p>";
                                    } else {
                                        
                                        editaAnimal($conn, $dados, $id);   
                                        
                                    }
                                }
                            }
                            
                        }

                        function editaAnimal( $conn, $dados, $id) {                          
    
                        
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
                                    if(empty($dados['pai'])) {
                                        $edit_usuario->bindParam(':pai', $dados['pai'], PDO::PARAM_NULL);
                                    } else {
                                        $edit_usuario->bindParam(':pai', $dados['pai'], PDO::PARAM_STR);
                                    }
                                    if(empty($dados['mae'])) {
                                        $edit_usuario->bindParam(':mae', $dados['mae'], PDO::PARAM_NULL);
                                    } else {
                                        $edit_usuario->bindParam(':mae', $dados['mae'], PDO::PARAM_STR);
                                    }
                                    if(empty($dados['litro'])) {
                                        $edit_usuario->bindParam(':litro', $dados['litro'], PDO::PARAM_NULL);
                                    } else {
                                        $edit_usuario->bindParam(':litro', $dados['litro'], PDO::PARAM_INT);
                                    }
                                    if(empty($dados['arroba'])) {
                                        $edit_usuario->bindParam(':arroba', $dados['arroba'], PDO::PARAM_NULL);
                                    } else {
                                        $edit_usuario->bindParam(':arroba', $dados['arroba'], PDO::PARAM_INT);
                                    }
                                    if(empty($dados['nascimento'])) {
                                        $edit_usuario->bindParam(':nascimento', $dados['nascimento'], PDO::PARAM_NULL);
                                    } else {
                                        $edit_usuario->bindParam(':nascimento', $dados['nascimento'], PDO::PARAM_STR);
                                    }
                                    if(empty($dados['aquisicao'])) {
                                        $edit_usuario->bindParam(':aquisicao', $dados['aquisicao'], PDO::PARAM_NULL);
                                    } else {
                                        $edit_usuario->bindParam(':aquisicao', $dados['aquisicao'], PDO::PARAM_STR);
                                    }
                                    if(empty($dados['venda'])) {
                                        $edit_usuario->bindParam(':venda', $dados['venda'], PDO::PARAM_NULL);
                                    } else {
                                        $edit_usuario->bindParam(':venda', $dados['venda'], PDO::PARAM_STR);
                                    }
                                   
                                  //  echo $dados['mae'];
                                    if($edit_usuario->execute()) {
                                        if ($edit_usuario->rowCount() == 0) {
                                            echo "CAIU NO IF2 - ";
                                            echo $edit_usuario->rowCount() . " - ";
                                            echo $edit_usuario->errorCode();
                                        } else {
                                            echo  "Feliz";
                                        }
                                        $_SESSION['msg'] =  "Animal editado com sucesso!";
                                        //header ("Location: listarAnimais.php");
                                        echo "CAIU NO IF";
                                    } else {
                                        $_SESSION['msg'] =  "Animal não editado!";
                                    }
                            
                        }               

                    ?>

                
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