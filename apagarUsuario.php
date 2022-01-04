<?php
session_start();
ob_start();
include_once './conexao.php';

$id = filter_input(INPUT_GET, "usu_id", FILTER_SANITIZE_NUMBER_INT);
//var_dump($id);

if(empty($id)) {
    $_SESSION['msg'] = "Usuário não encontrado!";
    header ("Location: listarUsuarios.php");
    exit();
}

$query_usuario = "SELECT USU_ID FROM USUARIO WHERE USU_ID = $id LIMIT 1";
$result_usuario = $conn->prepare($query_usuario);
$result_usuario->execute();

if(($result_usuario) AND ($result_usuario->rowCount() != 0)) {
    $query_del_usuario = "DELETE FROM USUARIO WHERE USU_ID = $id";
    $apagar_usuario = $conn->prepare($query_del_usuario);

    if($apagar_usuario->execute()) {
        header ("Location: listarUsuarios.php");
        echo "Usuário apagado com sucesso!";
    } else {
        $_SESSION['msg'] = "Usuário não apagado!";
    header ("Location: listarUsuarios.php");
    exit();
    }
} else {
    $_SESSION['msg'] = "Usuário não encontrado!";
    header ("Location: listarUsuarios.php");
    exit();
}