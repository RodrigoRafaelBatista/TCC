<?php
session_start();
ob_start();
include_once './conexao.php';

$id = filter_input(INPUT_GET, "bov_id", FILTER_SANITIZE_NUMBER_INT);
//var_dump($id);

if(empty($id)) {
    $_SESSION['msg'] = "Animal não encontrado!";
    header ("Location: listarAnimais.php");
    exit();
}

$query_animal = "SELECT BOV_ID FROM BOVINO WHERE BOV_ID = $id LIMIT 1";
$result_animal = $conn->prepare($query_animal);
$result_animal->execute();

if(($result_animal) AND ($result_animal->rowCount() != 0)) {
    $query_del_animal = "UPDATE BOVINO SET BOV_STA = 2 WHERE BOV_ID = $id AND BOV_USU = :bov_usu";
    $apagar_animal = $conn->prepare($query_del_animal);
    $apagar_animal->bindParam(':bov_usu', $_SESSION['USU_ID']);

    if($apagar_animal->execute()) {
        header ("Location: listarAnimais.php");
        echo "Animal apagado com sucesso!";
    } else {
        $_SESSION['msg'] = "Animal não apagado!";
    header ("Location: listarAnimais.php");
    exit();
    }
} else {
    $_SESSION['msg'] = "Animal não encontrado!";
    header ("Location: listarAnimais.php");
    exit();
}