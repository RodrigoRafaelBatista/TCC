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
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GestãoBov - Cadastrar Animal</title>
</head>
<body>
    <h1>Cadastrar Animal</h1>

    <form action="" name="cad-animal" method="POST">

        <label>Brinco: </label>
        <input type="text" name="brinco" id="brinco" placeholder="Insira número do brinco do animal" 
        value="<?php
            // mantém a informação no formulário
            if (isset($dados['brinco'])){
                echo $dados['brinco'];
            }
        ?>"> <br><br>

        <label>Tipo: </label>
        <select name="tipo" id="tipo">
            <option value="Corte">Corte</option>
            <option value="Leite">Leite</option>
        </select> <br><br>

        <label>Raça: </label>
        <select name="raca" id="raca">
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
        <select name="pai" id="pai">
            
            <?php
                $lista_opcoes = $conn->prepare("SELECT * FROM BOVINO WHERE BOV_USU = :bov_usu");                
                $lista_opcoes->bindParam(':bov_usu', $_SESSION['USU_ID']);
                $lista_opcoes->execute();
                $vazio = 'null';       // Talvez de pra tirar esta variavel
                echo "<option value='{$vazio}'> Não informado</option>";
                if($lista_opcoes->rowCount() != 0){ 
                    while($seleciona = $lista_opcoes->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='{$seleciona['BOV_ID']}'> Brinco nº {$seleciona['BOV_BRINCO']}</option>";
                    }
                }
            ?>
        </select> <br><br>

        <label>Mãe: </label>
        <select name="mae" id="mae">
            
            <?php
                $lista_opcoes = $conn->prepare("SELECT * FROM BOVINO WHERE BOV_USU = :bov_usu");                
                $lista_opcoes->bindParam(':bov_usu', $_SESSION['USU_ID']);
                $lista_opcoes->execute();
                $vazio = 'null';        // Talvez de pra tirar esta variavel
                echo "<option value='{$vazio}'> Não informado</option>";
                if($lista_opcoes->rowCount() != 0){ 
                    while($seleciona = $lista_opcoes->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='{$seleciona['BOV_ID']}'> Brinco nº {$seleciona['BOV_BRINCO']}</option>";
                    }
                }
            ?>
        </select> <br><br>

        <label>Produção Litro: </label>
        <input type="text" name="litro" id="litro" placeholder="Produção em litros de leite do animal" 
        value="<?php
            // mantém a informação no formulário
            if (isset($dados['leite'])){
                echo $dados['leite'];
            }
        ?>"> <br><br>

        <label>Produção Arroba: </label>
        <input type="text" name="arroba" id="arroba" placeholder="Produção em arroba" 
        value="<?php
            // mantém a informação no formulário
            if (isset($dados['arroba'])){
                echo $dados['arroba'];
            }
        ?>"> <br><br>

        <label>Data de Nascimento: Use o seguinte formato de data: ano-mes-dia (2020-01-01)</label>
        <input type="text" name="nascimento" id="nascimento" placeholder="Insira a data de nascimento do animal" 
        value="<?php
            // mantém a informação no formulário
            if (isset($dados['nascimento'])){
                echo $dados['nascimento'];
            }
        ?>"> <br><br>

        <label>Data de Aquisição: Use o seguinte formato de data: ano-mes-dia (2020-01-01)</label>
        <input type="text" name="aquisicao" id="aquisicao" placeholder="Insira a data de aquisição do animal" 
        value="<?php
            // mantém a informação no formulário
            if (isset($dados['aquisicao'])){
                echo $dados['aquisicao'];
            }
        ?>"> <br><br>

        <label>Data de Venda: Use o seguinte formato de data: ano-mes-dia (2020-01-01)</label>
        <input type="text" name="venda" id="venda" placeholder="Insira a data de venda do animal" 
        value="<?php
            // mantém a informação no formulário
            if (isset($dados['venda'])){
                echo $dados['venda'];
            }
        ?>"> <br><br>

        
        <input type="submit" value="Cadastrar" name="CadAnimal">

        

        <?php
            $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);        // Variável que recebe os dados preenchidos no formulário dentro de um array
            
            if(!empty($dados['CadAnimal'])){       // Verifica se a variável dados é diferente de vazio

                // var_dump($dados);
                $empty_input = false;       // Variável para saber se o usuário preencheu todos os campos do formulário, inicia como false(não preenchido)
                $dados = array_map('trim',  $dados);        // Remove os espaços do inicio ou final da String

                if(in_array("", $dados)){       // Verifica dentro da variável dados que é um array, se existe algum campo que é vazio, já com os espaços removidos
                    $empty_input = true;        // Se houver campos vazios então a variável se torna true e posteriormente o cadastro será recusado.
                    echo "<p style = 'color: red;'> Erro: É necessário preencher todos os campos!</p>";
                } /* elseif (!filter_var($dados['email'], FILTER_VALIDATE_EMAIL)){     // Validação se o e-mail preenchido tem caracterísicas de e-mail
                    $empty_input = true;
                    echo "<p style = 'color: red;'> Erro: O e-mail informado é inválido!</p>";
                } */

                if(!$empty_input){      // Se a variável for false, então todos os campos foram preenchidos corretamente e o cadastro será enviado para o MySQL
                    
                    $query_usuario = "CALL AddBov(1, :bov_usu, :brinco, :tipo, :raca, :pai, :mae, :litro, :arroba, :nascimento, :aquisicao, :venda);";        //Variável recebe a query SQL, no caso a procedure de cadastro de animal
    
                    $cad_animal = $conn->prepare($query_usuario);                           // Prepara a query para execução
                    $cad_animal->bindParam(':bov_usu', $_SESSION['USU_ID'], PDO::PARAM_INT);        // Determina o tipo de dado que será enviado para a variável     
                    $cad_animal->bindParam(':brinco', $dados['brinco'], PDO::PARAM_STR);            // Determina o tipo de dado que será enviado para a variável
                    $cad_animal->bindParam(':tipo', $dados['tipo'], PDO::PARAM_STR);                // Determina o tipo de dado que será enviado para a variável
                    $cad_animal->bindParam(':raca', $dados['raca'], PDO::PARAM_STR);                // Determina o tipo de dado que será enviado para a variável
                    $cad_animal->bindParam(':pai', $dados['pai'], PDO::PARAM_NULL);                  // Determina o tipo de dado que será enviado para a variável
                    $cad_animal->bindParam(':mae', $dados['mae'], PDO::PARAM_NULL);                  // Determina o tipo de dado que será enviado para a variável
                    $cad_animal->bindParam(':litro', $dados['litro'], PDO::PARAM_STR);              // Determina o tipo de dado que será enviado para a variável
                    $cad_animal->bindParam(':arroba', $dados['arroba'], PDO::PARAM_STR);            // Determina o tipo de dado que será enviado para a variável
                    $cad_animal->bindParam(':nascimento', $dados['nascimento'], PDO::PARAM_STR);    // Determina o tipo de dado que será enviado para a variável
                    $cad_animal->bindParam(':aquisicao', $dados['aquisicao'], PDO::PARAM_STR);      // Determina o tipo de dado que será enviado para a variável
                    $cad_animal->bindParam(':venda', $dados['venda'], PDO::PARAM_STR);              // Determina o tipo de dado que será enviado para a variável
                    $cad_animal->execute();                                                         // Executa a query (envia para o banco, conforme o arquivo conexao)
    
                    // Verifica se o cadastro foi feito com sucesso e retorna na tela com uma mensagem
                    if($cad_animal->rowCount()){
                        echo "<p style = 'color: green;'> Animal cadastrado com sucesso!</p>";
                        unset($dados);
                    } else {
                        echo "<p style = 'color: red;'> Erro: Animal não cadastrado!</p>";
                    }
                }
            }
        ?>

    </form>
    <button onclick="window.location.href = './dashboard.php'">Voltar</button>
</body>
</html>